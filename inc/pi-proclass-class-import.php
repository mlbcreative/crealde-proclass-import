<?php
	
	class ProClassImport {
		
		
		private $msg;
		private $classid = "";
		
		public function __construct($id) {
			$this->classid = $id;
		}
		
		

		public function fetchClass() {
			
			
			$username = 'CrealdeApi';
			$password = 'U9bW!2oRR';
			$url = 'https://api112.imperisoft.com/api/Programs/' . $this->classid;
			$args = array(
			    'headers' => array(
			        'Authorization' => 'Basic ' . base64_encode( $username . ':' . $password )
			    )
			);
			
			$request = $request = wp_remote_request( $url, $args );
	
	
	
			if( is_wp_error( $request ) ) {
				$error =  "Ooops. Something happened. Try importing again.";
				return $error; // Bail early
			} else {
				
				$body = wp_remote_retrieve_body( $request );
		
				$data = json_decode( $body );
				
				$this->parseClass($data);
				
			}			
			
		}
		
		
		private function parseClass($data) {
			
			$proclass = $data;
			
			
			
			if ( !empty($proclass) ) {
				
				
				
				$args = array(
				
				'post_type' => 'proclass',
				'post_title' => $proclass->Title,
				'post_content' => $proclass->OnlineRegistrationDescription,
				'post_status' => 'draft',
					
				);
				
				//56152
				
				$post = wp_insert_post($args);
				
				
				//do some work on the program type to determine if its a class or workshop
				
				$program_type = "";
				
				$proclass->ProgramType->Description;
				
				switch ($proclass->ProgramType->Description) {
					
					case "Young Artist":
					$program_type = "Young Artist";
					break;
					
					case "Young Adult":
					$program_type = "Young Artist";
					break;
					
					case "Art Camp":
					$program_type = "Art Camp";
					break;
					
					case "Workshop":
					$program_type = "Workshop";
					break;
					
					default:
					$program_type = "Class";
					break;
					
				}
/*
				if( $program_type != 'Workshop' || $program_type != 'Art Camp' || $program_type != 'Young Artist') {
					$program_type = "Class";
				}
*/
				
				//add the program type for filtering
				update_field('program_type', $program_type, $post);
				//add the semester id
				update_field('semester_id', $proclass->SemesterId, $post);
				//add start date
				update_field('start_date', $proclass->StartDate, $post);
				//add End Date
				update_field('end_date', $proclass->EndDate, $post);
				//add tuition
				update_field('tuition', $proclass->TuitionFee, $post);
				//add notes
				update_field('special_notes', $proclass->SpecialNotes, $post);
				//add supplies
				update_field('supply_list', $proclass->SupplyList, $post);
				//add Class image
				if( $proclass->HasImage == true) {
					update_field('class_image', $proclass->ImageUrl, $post);
				}
				//level update
				update_field('level', $proclass->Level, $post);
				//instructor
				update_field('instructor_id', $proclass->ProgramInstructors[0]->InstructorId, $post);
				//start time
				update_field('start_time', $proclass->StartTime, $post);
				//end time
				update_field('end_time', $proclass->EndTime, $post);
				update_field('location', $proclass->LocationName, $post);
				update_field('proclass_id', $proclass->ProgramId, $post);
				update_field('program_detail_link', 'https://reg125.imperisoft.com/Crealde/ProgramDetail/' . $proclass->ProgramDetailId . '/Registration.aspx', $post);
				update_field('media_list', $proclass->MediaList, $post);
				
				//let's get the instructor First and Last Name
				
				$this->getInstructorMeta($proclass->ProgramInstructors[0]->InstructorId, $post, $proclass->Title, $this->classid);
				
				
				
			} else {
				
				echo "Looks like that Class doesn't exist.";
				
				return;
				
			}	
			
		}
		
		private function getInstructorMeta($instructorid, $p, $class_name, $class_id) {
			
			//credentials again		
			$username = 'CrealdeApi';
			$password = 'U9bW!2oRR';
			$instructor_url = 'https://api112.imperisoft.com/api/Instructors/' . $instructorid;
			$args = array(
			    'headers' => array(
			        'Authorization' => 'Basic ' . base64_encode( $username . ':' . $password )
			    )
			);
			
			$request = $request = wp_remote_request( $instructor_url, $args );
	
	
	
			if( is_wp_error( $request ) ) {
				$error =  "Ooops. Something happened. Try importing again.";
				return $error; // Bail early
			} else {
				
				$body = wp_remote_retrieve_body( $request );
		
				$data = json_decode( $body );
				
				if( !empty($data) ) {
					
					$instructor = $data;// a more friendly variable name
					$firstname = $instructor->Contact->FirstName;//
					$lastname = $instructor->Contact->LastName;
					
					$fullname = $firstname . ' ' . $lastname;
					
					update_field('instructor_full_name', $fullname, $p);
					
								
					//We're all set. Let's get out of here.
	
					echo 'Successfully imported ' . $class_name . ' (' . $class_id  . ') from ProClass.';
					
					return;

					
					
				}
				
								
				
				
			}
			
		}
		
		
		
	}