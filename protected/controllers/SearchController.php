<?php

error_reporting(E_ALL ^ ~E_NOTICE ^ ~E_WARNING);
class SearchController extends Controller
{
    public $keyword;
    
    public $data;
   public  $numericalValue = '123456789';
  /**
     * @var string index dir as alias path from <b>application.</b>  , default to <b>runtime.search</b>
     */
    public  $_indexFiles = '\runtime\search';
 
    /**
     * (non-PHPdoc)
     * @see CController::init()
     */
		    public function init(){
					        Yii::import('application.vendor.*');
					        require_once('Zend/Search/Lucene.php');
					        parent::init(); 
		    }
		    public function actionIndex()
		    {
		    	$this->render('index');
		    }
		    
		    /*
		     *
	   //CREATE ACTION TO CREATE SEARCH INDEX FOR DOCUMENT FILES
	    * 
	    */
    	public function actionCreate()
		 {
		 	       //CREATING INDEX TO SEARCH DOCUMENT
		 	       
		    		$_indexFiles = '\runtime\search';
		    	    $index = Zend_Search_Lucene::create($_indexFiles);
		    		$index = new Zend_Search_Lucene(Yii::getPathOfAlias('application.' . $this->_indexFiles), true);
		    		$index = new Zend_Search_Lucene($this->_indexFiles,true);

    		
    		
	    		    //CODE  TO GET THE EXTENTION OF FILE
	    		   /*
	    		    if(($pos=strrpos($post->file,'.'))!==false)
	    			$ext=substr($post->file,$pos+1);
	    			
	    			*/
		    		/*
		    		 *
				    //THIS FUCTION IS USE TO READ THE CONTENT OF DOC FILE FOR SEACHING .		
				     * 
				     */ 

				    	function read_doc($filename)	{
						$fileHandle = fopen($filename, "r");
						$line = @fread($fileHandle, filesize($filename));   
						$lines = explode(chr(0x0D),$line);
						$outtext = "";
						foreach($lines as $thisline)
						  {
							$pos = strpos($thisline, chr(0x00));
							if (($pos !== FALSE)||(strlen($thisline)==0))
							  {
							  } else {
								$outtext .= $thisline." ";
							  }
						  }
						 $outtext = preg_replace("/[^a-zA-Z0-9\s\,\.\-				\n\r\t@\/\_\(\)]/","",$outtext);
						return $outtext;
					}
					
					/*
					 *
					//METHOD TO READ THE TEXT OF ODT FILE
					 * 
					 */
				    	function odt_to_text($input_file){
				        $xml_filename = "content.xml"; //content file name
				        $zip_handle = new ZipArchive;
				        $output_text = "";
				        if(true === $zip_handle->open($input_file)){
				                if(($xml_index = $zip_handle->locateName($xml_filename)) !== false){
				                        $xml_datas = $zip_handle->getFromIndex($xml_index);
				                     //   $var = new DOMDocument;
				                        $xml_handle = @DOMDocument::loadXML($xml_datas, LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_NOERROR | LIBXML_NOWARNING);
				                        $output_text = strip_tags($xml_handle->saveXML());
				                }else{
				                        $output_text .="";
				                }
				                $zip_handle->close();
				        }else{
				        $output_text .="";
				        }
				        return $output_text;
				   }
	
				   /*
				    *
			         METHOD TO EXTRACT FROM DOCX FILE
			          * 
			          */	
			    		function read_file_docx($filename)
			    		{
			    			$striped_content = '';
			    			$content = '';
			    			if(!$filename || !file_exists($filename)) return false;
			    			$zip = zip_open($filename);
			    			if (!$zip || is_numeric($zip)) return false;
			    			while ($zip_entry = zip_read($zip)) {
			    				if (zip_entry_open($zip, $zip_entry) == FALSE) continue;
			    				if (zip_entry_name($zip_entry) != "word/document.xml") continue;
			    				$content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
			    				zip_entry_close($zip_entry);
			    			}
			    			zip_close($zip);
			    			$content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
			    			$content = str_replace('</w:r></w:p>', "\r\n", $content);
			    			$striped_content = strip_tags($content);
			    		
			    			return $striped_content;
			    		}
			    		
			    		/*
			    		 *
				    		 METHOD TO EXTRACT FROM PPT FILE
				    		 * 
				    		 */
				    		 
				    		 function pptx_to_text($input_file){
				    		$zip_handle = new ZipArchive;
				    		$output_text = "";
				    		if(true === $zip_handle->open($input_file)){
				    		$slide_number = 1; //loop through slide files
				    		while(($xml_index = $zip_handle->locateName("ppt/slides/slide".$slide_number.".xml")) !== false){
				    		$xml_datas = $zip_handle->getFromIndex($xml_index);
				    		$xml_handle =@DOMDocument::loadXML($xml_datas, LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_NOERROR | LIBXML_NOWARNING);
				    		$output_text .= strip_tags($xml_handle->saveXML());
				    		$slide_number++;
				    		}
				    		if($slide_number == 1){
				    		$output_text .="";
				    		}
				    		$zip_handle->close();
				    		}else{
				    		$output_text .="";
				    		}
				    		return $output_text;
				    		}
				    		 
				    		/*
				    		 *
				    		
				    	METHOD TO READ PPT CONTENT	
				    	 * 
				    	 */
						    function parsePPT($filename) {
						    // This approach uses detection of the string
						
						    $fileHandle = fopen($filename, "r");
						    $line = @fread($fileHandle, filesize($filename));
						    $lines = explode(chr(0x0f),$line);
						    $outtext = '';
						
						    foreach($lines as $thisline) {
						        if (strpos($thisline, chr(0x00).chr(0x00).chr(0x00)) == 1) {
						            $text_line = substr($thisline, 4);
						            $end_pos   = strpos($text_line, chr(0x00));
						            $text_line = substr($text_line, 0, $end_pos);
						            $text_line =
						         preg_replace("/[^a-zA-Z0-9\s\,\.\-\n\r\t@\/\_\(\)]/","",$text_line);
						            if (strlen($text_line) > 1) {
						                $outtext.= substr($text_line, 0, $end_pos)."\n";
						            }
						        }
						    }
						    return $outtext;
						    }
				    
						    /*
						     *
				    		 METHOD TO EXTRACT FROM EXCEL FILE
				    		 * 
				    		 */
				    		function xlsx_to_text($input_file){
				    			$xml_filename = "xl/sharedStrings.xml"; //content file name
				    			$zip_handle = new ZipArchive;
				    			$output_text = "";
				    			if(true === $zip_handle->open($input_file)){
				    				if(($xml_index = $zip_handle->locateName($xml_filename)) !== false){
				    					$xml_datas = $zip_handle->getFromIndex($xml_index);
				    					$xml_handle = @DOMDocument::loadXML($xml_datas, LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_NOERROR | LIBXML_NOWARNING);
				    					$output_text = strip_tags($xml_handle->saveXML());
				    				}else{
				    					$output_text .="";
				    				}
				    				$zip_handle->close();
				    			}else{
				    				$output_text .="";
				    			}
				    			return $output_text;
				    		}
				    		
				    		
				    		/*
				    		 *
				    		 FOR EXTRACT DATA OF PDF FILE
				    		  * 
				    		  */
				    		 
				    		function ExtractTextFromPdf ($pdfdata) {
				    			if (strlen ($pdfdata) < 1000 && file_exists ($pdfdata)) $pdfdata = file_get_contents ($pdfdata); //get the data from file
				    			if (!trim ($pdfdata)) echo "Error: there is no PDF data or file to process.";
				    			$result = ''; //this will store the results
				    			//Find all the streams in FlateDecode format (not sure what this is), and then loop through each of them
				    			if (preg_match_all ('/<<[^>]*FlateDecode[^>]*>>\s*stream(.+)endstream/Uis', $pdfdata, $m)) foreach ($m[1] as $chunk) {
				    				$chunk = gzuncompress (ltrim ($chunk)); //uncompress the data using the PHP gzuncompress function
				    				//If there are [] in the data, then extract all stuff within (), or just extract () from the data directly
				    				$a = preg_match_all ('/\[([^\]]+)\]/', $chunk, $m2) ? $m2[1] : array ($chunk); //get all the stuff within []
				    				foreach ($a as $subchunk) if (preg_match_all ('/\(([^\)]+)\)/', $subchunk, $m3)) $result .= join ('', $m3[1]); //within ()
				    			}
				    			else echo "Error: there is no FlateDecode text in this PDF file that I can process.";
				    			return $result; //return what was found
				    		}
    		
    		
    		
    	
    		 
    		    $posts = Asset::model()->findAll(); //LOADING ASSET MODULE TO SEARCH DOCUMENT
    		    
    		    // FOR EACH LOOP TO GET THE DATA
    	       foreach($posts as $post){
    		 
    		  
    		    	 if(($pos=strrpos($post->file,'.'))!==false)
    					$ext=substr($post->file,$pos+1);
    		 
							    		
							      if ($ext==='docx')//INDEXING DOCX FILE INTO SEARCH
							       {
							    		 
							    		  $a = $post->categoryId;
							    		  $b =   $b=$post->orgId;
							    	   //creating a document for docx file
							    	 $doc = Zend_Search_Lucene_Document_Docx::loadDocxFile(Yii::app()->basePath.'\..\upload\\'.$b.'\\'.$a.'\\'.$post->assetId.'.docx');

							    	  $numericalValue = '123456789';

							    	  $doc->addField(Zend_Search_Lucene_Field::Keyword('keyword', $this->numericalValue));
							    	  
							    	 //exttracting data for searching in docx  file content. 
							    	 $data=read_file_docx(Yii::app()->basePath.'\..\upload\\'.$b.'\\'.$a.'\\'.$post->assetId.'.docx');
							    	 
							    	//adding fields to search document. 
							    	 $doc->addField(Zend_Search_Lucene_Field::Text('link',
							    			CHtml::encode($post->url)
							    			, 'utf-8')
							    	);
							    	 
							    	 //adding fields name to search document with assetId.
							    	 $doc->addField(Zend_Search_Lucene_Field::Text('name',
							    	 		CHtml::encode($post->assetId), 'utf-8')
							    	 );
							    	 
							    	 //adding fieldstitle to search document file name.
							    	 $doc->addField(Zend_Search_Lucene_Field::Text('title',
							    	 		CHtml::encode($post->file)
							    	 		, 'utf-8')
							    	 );
							    	 //adding field content to search document with data of file. 
							    	 $doc->addField(Zend_Search_Lucene_Field::Text('content',
							    	 		CHtml::encode($data)
							    	 		, 'utf-8')
							    	 );
							    	 
							    	 //adding document to search. 
							    	 $index->addDocument($doc);
							    	  
							    	 
							       }  
							    	 elseif($ext=='pptx') //INDEXING PPTX FILE INTO SEARCH
							    	 
							    	 {
							     		  $a = $post->categoryId;
							     		  $b=$post->orgId;
							     		  
							    	 //here craeting an document to add pptx files into search index 
							        $doc1 = Zend_Search_Lucene_Document_Pptx::loadPptxFile(Yii::app()->basePath.'\..\upload\\'.$b.'\\'.$a.'\\'.$post->assetId.'pptx');
							    	
							       $numericalValue = '123456789';
							        
							        $doc1->addField(Zend_Search_Lucene_Field::Keyword('keyword', $this->numericalValue));
							        
							        //etracting pptx file text to add it in search document
							        $data=pptx_to_text(Yii::app()->basePath.'\..\upload\\'.$b.'\\'.$a.'\\'.$post->assetId.'.pptx');
							    	
									//adding field title to search document  with file name							    	
							    	$doc1->addField(Zend_Search_Lucene_Field::Text('title',
							    			CHtml::encode($post->file)
							    			, 'utf-8')
							    	);
							    	
							    	
							    	//adding content field to search document with content of pptx file.
							    	$doc1->addField(Zend_Search_Lucene_Field::Text('content',
							    			CHtml::encode($data)
							    			, 'utf-8')
							    	);
							    	
							    	//adding name field to search with assetId
							    	$doc1->addField(Zend_Search_Lucene_Field::Text('name',
							    			CHtml::encode($post->assetId), 'utf-8')
							    	);
							    	
							    	//adding link field to search document  with url
							    	$doc1->addField(Zend_Search_Lucene_Field::Text('link',
							    			CHtml::encode($post->url)
							    			, 'utf-8')
							    	);
							    	
							    	//adding document to  search index
							    	  $index->addDocument($doc1);
							    	 }
							    	 
							    	 elseif($ext=='xlsx') //INDEXING XLSX FILE INTO SEARCH
							    	 {
							    	 	
							    	       $a = $post->categoryId;
							    		    $b=$post->orgId;
							    	 
							    	    
							       
							    	//here creating document to load xlsx file in search document
							    	$doc3 = Zend_Search_Lucene_Document_Xlsx::loadXlsxFile(Yii::app()->basePath.'\..\upload\\'.$b.'\\'.$a.'\\'.$post->assetId.'.xlsx');
							    	$numericalValue = '123456789';
							    	
							    	$doc3->addField(Zend_Search_Lucene_Field::Keyword('keyword', $this->numericalValue));
							    	
							    	//here extracting text of xlsx file to search in conent 
							    	$data=xlsx_to_text(Yii::app()->basePath.'\..\upload\\'.$b.'\\'.$a.'\\'.$post->assetId.'.xlsx');
							    	
							    	 //here adding link field to search document with url.
							    	$doc3->addField(Zend_Search_Lucene_Field::Text('link',
							    			CHtml::encode($post->url)
							    			, 'utf-8')
							    	);
							    	
							    	//here adding name field to search document with asset id. 
							    	$doc3->addField(Zend_Search_Lucene_Field::Text('name',
							    			CHtml::encode($post->assetId), 'utf-8')
							    	);

							    	//here adding title field in search document with filename
							    	$doc3->addField(Zend_Search_Lucene_Field::Text('title',
							    			CHtml::encode($post->file)
							    			, 'utf-8')
							    	);
							    	
							    	//here adding content field in search document with extracted data
							    	$doc3->addField(Zend_Search_Lucene_Field::Text('content',
							    			CHtml::encode($data)
							    			, 'utf-8')
							    	);
							    	
							    	// adding document into search index.
							    	 $index->addDocument($doc3);
							    	    
							    	 }
							
							    	 else if ($ext == 'doc') //INDEXING DOC  FILE INTO SEARCH
							    	 {
							    	 	$a = $post->categoryId;
							    	 	  $b=$post->orgId;
							    	 		
							    	 	//creating instance of document for doc file 
							    	 	$doc = new Zend_Search_Lucene_Document();
							    	 	
							    	 	$numericalValue = '123456789';
							    	 	
							    	 	$doc->addField(Zend_Search_Lucene_Field::Keyword('keyword', $this->numericalValue));
							    	 	
							    	 	//extracting data from bdaoc file to add it into search document,
 										$data1 = read_doc(Yii::app()->basePath.'\..\upload\\'.$b.'\\'.$a.'\\'.$post->assetId.'doc');
							    	 	
							    	 	$data=substr($data1,0,1000);
							    	 	 
							    	 	//adding link field to search document with url
							    	 	 $doc->addField(Zend_Search_Lucene_Field::Text('link',
							    			CHtml::encode($post->url)
							    			, 'utf-8')
							    		);
							    	 
							    	 	 //adding name field to search document with asset id
							    	 $doc->addField(Zend_Search_Lucene_Field::Text('name',
							    	 		CHtml::encode($post->assetId), 'utf-8')
							    	 );
							    	 
							    	 //adding title field in search document with file name
							    	 $doc->addField(Zend_Search_Lucene_Field::Text('title',
							    	 		CHtml::encode($post->file)
							    	 		, 'utf-8')
							    	 );
							    	 
							    	 //adding content field in search document with extracted data from doc file
							    	 $doc->addField(Zend_Search_Lucene_Field::Text('content',
							    			CHtml::encode($data)
							    			, 'utf-8')
							    	);
							     
							    	 //adding search document to search index
							    	 $index->addDocument($doc);
							    	 		
							    	 
							      }else if ($ext == 'odt') //INDEXING ODT FILE INTO SEARCH
							      
							        {
							      	$a = $post->categoryId;
							      	  $b=$post->orgId;
							      		
							    	 	//creating instance of search document to add odt file 
							    	 	$doc = new Zend_Search_Lucene_Document();
							    	 	
							    	 	//here  text is extracted  to search  
							    	 	$data = odt_to_text(Yii::app()->basePath.'\..\upload\\'.$b.'\\'.$a.'\\'.$post->assetId.'.odt');
							    	 	
							    	 	$numericalValue = '123456789';
							    	 	
							    	 	$doc->addField(Zend_Search_Lucene_Field::Keyword('keyword', $this->numericalValue));
							    	 	
							    	 	 
							    	 	 //adding link field in search document with url
							    	 	 $doc->addField(Zend_Search_Lucene_Field::Text('link',
							    			CHtml::encode($post->url)
							    			, 'utf-8')
							    		);
							    	 
							    	 	 //adding  name fioeld in search document with assetid
							    	 $doc->addField(Zend_Search_Lucene_Field::Text('name',
							    	 		CHtml::encode($post->assetId), 'utf-8')
							    	 );
							    	 
							    	 //adding title field in search document with file name
							    	 $doc->addField(Zend_Search_Lucene_Field::Text('title',
							    	 		CHtml::encode($post->file)
							    	 		, 'utf-8')
							    	 );
							    	 
							    	 //here adding content field search document with extracted data
							    	 $doc->addField(Zend_Search_Lucene_Field::Text('content',
							    			$data
							    			, 'utf-8')
							    	);
							     
							    	 //here the search document is added to search index
							    	 $index->addDocument($doc);
							    	 		
							    	 
							      }  else if ($ext == 'pdf') //INDEXING PDF FILE INTO SEARCH
							      
							      {
							      	
							      	$a = $post->categoryId;
							      	  $b=$post->orgId;
							      		
							    	 //creating instant of search document for pdf file	
							      	$doc5 = new Zend_Search_Lucene_Document();
							      	//here extracting the text from pdf file for content search
							      	$data1 = ExtractTextFromPdf (Yii::app()->basePath.'\..\upload\\'.$b.'\\'.$a.'\\'.$post->assetId.'.pdf');
							      	 
							      	 $numericalValue = '123456789';
							      	
							      	$doc5->addField(Zend_Search_Lucene_Field::Keyword('keyword', $this->numericalValue));
							      	
							      	
							      	$data=substr($data1,0,1000);
							      	 
							      	//adding content field to search document with extracted data
							      	 $doc5->addField(Zend_Search_Lucene_Field::Text('content',
							      	 		 $data
							      	 		 )
							      	 );
							      	 
							      	 //adding link field to search document wit url
							      	$doc5->addField(Zend_Search_Lucene_Field::Text('link',
							      			CHtml::encode($post->url)
							      			, 'utf-8')
							      	);
							      		
							      	//adding name field to search document with asset id
							      	$doc5->addField(Zend_Search_Lucene_Field::Text('name',
							      			CHtml::encode($post->assetId), 'utf-8')
							      	);
							      		
							      	//adding title field to search document with file name
							      	$doc5->addField(Zend_Search_Lucene_Field::Text('title',
							      			CHtml::encode($post->file)
							      			, 'utf-8')
							      	);
							      		
							      	
							      	//ADDIND PDF DOCUMENT TO SEARCH
							      	$index->addDocument($doc5);
							      	 
							      	 
							    	 
							      }   else if ($ext == 'ppt')//INDEXING PPT FILE INTO SEARCH
							        {
									      	$a = $post->categoryId;
									        $b=$post->orgId;
									      		
							    	 
							      		$doc = new Zend_Search_Lucene_Document();
							      		
							      		//here browsing a file to add the content of file  to lucene search document.
							    	 	$data = pptx_to_text(Yii::app()->basePath.'\..\upload\\'.$b.'\\'.$a.'\\'.$post->assetId.'.ppt');
							    	 	 
							    	 	$numericalValue = '123456789';
							    	 	
							    	 	$doc->addField(Zend_Search_Lucene_Field::Keyword('keyword', $this->numericalValue));
							    	 	
							    	 	//adding link of file to lucene search document.
							    	 	 $doc->addField(Zend_Search_Lucene_Field::Text('link',
							    			CHtml::encode($post->url)
							    			, 'utf-8')
							    		);
							    	 
							    	 	 //adding name field of file to search document.
							    	 $doc->addField(Zend_Search_Lucene_Field::Text('name',
							    	 		CHtml::encode($post->assetId), 'utf-8')
							    	 );
							    	 
							    	 //adding title field of file to search document..
				
							    	 $doc->addField(Zend_Search_Lucene_Field::Text('title',
							    	 		CHtml::encode($post->file)
							    	 		, 'utf-8')
							    	 );
							    	 
							    	 //here adding content to lucene search index.
							    	 $doc->addField(Zend_Search_Lucene_Field::Text('content',
							    			CHtml::encode($data)
							    			, 'utf-8')
							    	);
							     
							    	 
							    	// adding this document 
							    	 $index->addDocument($doc);
							    	 		
							    	 
							      }  
							      else {
							      	 
							      	//INDEXING OTHER FILES INTO SEARCH
							      	
							      	     $doc = new Zend_Search_Lucene_Document();
							    	 	 
							    	 	 //	adding link to search
							    	 	 $doc->addField(Zend_Search_Lucene_Field::Text('link',
							    			CHtml::encode($post->url)
							    			, 'utf-8')
							    		);
							    	 	 
							    	 	$numericalValue = '123456789';
							    	 	 
							    	 	 $doc->addField(Zend_Search_Lucene_Field::Keyword('keyword', $this->numericalValue));
							    	 	 
							    	 	 //	adding name field to search
							    	  $doc->addField(Zend_Search_Lucene_Field::Text('name',
							    	 		CHtml::encode($post->assetId), 'utf-8')
							    	  );
							    	 //adding title fieild to search
							    	  $doc->addField(Zend_Search_Lucene_Field::Text('title',
							    	 		CHtml::encode($post->file)
							    	 		, 'utf-8')
							    	  );
							     
							    	  //adding this document to search index
							    	   $index->addDocument($doc);
                                }
    	
      
    		
                      }
    
    
       
              //HERE LOADING TAGS TABLE TO SEARCH
    	      $posts = Tags::model()->findAll();  
     
              foreach($posts as $post){
              	                    // here creating document for  tag 
					              	$doc5 = new Zend_Search_Lucene_Document();
					              		
					              	//here adding title to search document with tag name.
					              	$doc5->addField(Zend_Search_Lucene_Field::Text('title',
					              			CHtml::encode($post->tagName), 'utf-8')
					              	);
					               //here adding name to search document with tag id.
					              	$doc5->addField(Zend_Search_Lucene_Field::Text('name',
					              			CHtml::encode($post->tagId), 'utf-8')
					              	);
					              		
					              	//here adding link to search document with url.
					              	$doc5->addField(Zend_Search_Lucene_Field::Text('link',
					              			CHtml::encode($post->url)
					              			, 'utf-8')
					              	);
					              	
					              	$numericalValue = '123456789';
					              	
					              	$doc->addField(Zend_Search_Lucene_Field::Keyword('keyword', $this->numericalValue));
					              	
					              		//here adding content to search document with ornization id.
					              	$doc5->addField(Zend_Search_Lucene_Field::Text('content',
					              			CHtml::encode($post->orgId)
					              			, 'utf-8')
					              	);
					              		//adding search document to lucene search index.
					              	  $index->addDocument($doc5);
					              		
              	               
				              		
				              		
				              		
				              		
				              		
				          }
				              	
							    	 
              	                    
							    	
                     
    
    	   
    	 
    	 
    		
    	                    //COMMITING INDEX HERE
    	     
				    		 $index->commit();
				    		 echo 'Lucene index created';
    		
    	 	 
    		
    	}
    
    	/*
    	 *
     SEARCH ACTION TO SEARCH FOR DOCUMENT
     *
     */
		    public function actionSearch()
		    {
		    	
								//LOADING INDEX TO PERFORM SEARCH IN DOCUMENT
		    	                $this->layout='column2';
						        $_indexFiles = '\runtime\search';
						        $index = Zend_Search_Lucene::create($_indexFiles);
						        $index = new Zend_Search_Lucene(Yii::getPathOfAlias('application.' . $this->_indexFiles), true);
						    	$index = new Zend_Search_Lucene($this->_indexFiles,true);
						        $this->layout='column2';
		
						        // GETING THE PARAMETER STRING TO SEARCH IN DOCUMENT
							    	if ((($term = Yii::app()->getRequest()->getParam('q', null)) !== null)) {
							    		
							    		//calling create() to create search index at run time. 
							    	   $this->actionCreate();
							
							    	   $index = Zend_Search_Lucene::open($_indexFiles);
							    		
							    		$results = $index->find($term);
							    		$query = Zend_Search_Lucene_Search_QueryParser::parse($term,'utf-8');
							    	
							    		$this->render('search',compact('results', 'term', 'query'));
							    	}
				    	  
		    	
		     }
		    
		     /*
		      *
     // SEARCH ACTION TO SEARCH FOR IMAGES
      * 
      */
    public function actionSearch1()
    {
    			//LOADING INDEX TO PERFORM SEARCH FOR IMAGE
		    	$flag=1;
		    	$this->layout='column2';
		        $_indexFiles = '\runtime\search';
		    	$index = Zend_Search_Lucene::create($_indexFiles);
		        $index = new Zend_Search_Lucene(Yii::getPathOfAlias('application.' . $this->_indexFiles), true);
		    	$index = new Zend_Search_Lucene($this->_indexFiles,true);
		    	$this->layout='column2';
		    	 
		    	 //GETING THE IMAGE NAME TO PERFORM SEARCH
		    	if ((($term = Yii::app()->getRequest()->getParam('param', null)) !== null)) {
		    
		    		 //calling create() method to create search index at runtime eachtime. 
		    		$this->actionCreate1();

		    		//here opening a index to read data for search  
		    		$index = Zend_Search_Lucene::open($_indexFiles);
		    
		    		$results = $index->find($term);
		    		$query = Zend_Search_Lucene_Search_QueryParser::parse($term,'utf-8');
		    		 
		    		$this->render('search',compact('results', 'term', 'query','flag'));
		    	}
		    	 
    	 
    }
    
    /*
     *
    CREATE ACTION TO CREATE SEARCH INDEX FOR IMAGE FILES
     * 
     */
    public function actionCreate1()
    {
    	 //CREATING INDEX TO SEARCH
    	 $_indexFiles = '\runtime\search';
         $index = Zend_Search_Lucene::create($_indexFiles);
    	 $index = new Zend_Search_Lucene(Yii::getPathOfAlias('application.' . $this->_indexFiles), true);
    	 $index = new Zend_Search_Lucene($this->_indexFiles,true);
    
    	 
    	 
    	$posts = Asset::model()->findAll();//LOADING ASSET MODUL TO SEARCH IMAGE
    
    	 
    		 
    	   foreach($posts as $post){
    		
    		  
				    		 //here we are getting the extention of file 
				    		if(($pos=strrpos($post->file,'.'))!==false)
				    			$ext=substr($post->file,$pos+1);
				    		 
				    		//here we are getting the image file and adding it to search index.
				    		if ($ext==='jpg'|| $ext==='gif'|| $ext==='png'|| $ext==='ani'|| $ext==='bmp'|| $ext==='cal'|| $ext==='fax'|| $ext==='img'|| $ext==='jbg'|| $ext==='jpe'|| $ext==='mac'|| $ext==='pbm'|| $ext==='pcd'|| $ext==='pcx'|| $ext==='pct'|| $ext==='pgm'|| $ext==='ppm'|| $ext==='psd'|| $ext==='ras'|| $ext==='tga'|| $ext==='tiff'|| $ext==='wma')
				    		{
				    			$doc = new Zend_Search_Lucene_Document();  //here the index of zend lucene search is created
				    			
				    		    $numericalValue = '123456789';
				    			
				    			$doc->addField(Zend_Search_Lucene_Field::Keyword('keyword', $this->numericalValue));
				    			
				    			
				    			//fields of zend search index is initialized here for searching.
				    			$doc->addField(Zend_Search_Lucene_Field::Text('name',
				    					CHtml::encode($post->assetId), 'utf-8')
				    			);
				    			//here adding a tilte of search document with file name
				    			$doc->addField(Zend_Search_Lucene_Field::Text('title',
				    					CHtml::encode($post->file), 'utf-8')
				    			);
				    
		
				    			//here adding a link field to search document with orgnization id. 
				    			$doc->addField(Zend_Search_Lucene_Field::Text('link',
				    					CHtml::encode($post->orgId)
				    					, 'utf-8')
				    			);
				    
				    			//here adding a content field to search document with categoryid.
				    			$doc->addField(Zend_Search_Lucene_Field::Text('content',
				    					CHtml::encode($post->categoryId)
				    					, 'utf-8')
				    			);
				    
				              // here adding document to search index.
				    			$index->addDocument($doc);
    		     } 
    
    	}
    
    				  //
    	 
				    	$index->commit();
				    	echo 'Lucene index created';
    
    
    
    }
     
    /*
     *
    SEARCH ACTION TO SEARCH FOR VIDEO
    *
     */
    public function actionSearch2()
    {
    	 			// here calling a search index for searcing in video  file 
			    	$flag=2;
			    	$this->layout='column2';
			        $_indexFiles = '\runtime\search';
			        $index = Zend_Search_Lucene::create($_indexFiles);
			        $index = new Zend_Search_Lucene(Yii::getPathOfAlias('application.' . $this->_indexFiles), true);
			    	$index = new Zend_Search_Lucene($this->_indexFiles,true);
			    	$this->layout='column2';
			    	
			        // GETTING SEARCH PARAMETER TO SEARCH IN VIDEOS
    	            if ((($term = Yii::app()->getRequest()->getParam('param', null)) !== null)) {
    
    		 
    	            	//here calling create() for  creating index
					    		$this->actionCreate2();
					    
					    		// here openig a index for search
					    		$index = Zend_Search_Lucene::open($_indexFiles);
					    
					    		//here getting a results for search term.
					    		$results = $index->find($term);
					    		$query = Zend_Search_Lucene_Search_QueryParser::parse($term,'utf-8');
					    		
					    		 
					    		 
					    		$this->render('search',compact('results', 'term', 'query','flag'));
    			}
    
    
    }
    
    /*
     *
    CREATE ACTION TO CREATE SEARCH INDEX FOR VIDEO FILES
    *
     */
    public function actionCreate2()
    {
    	
    				//CREATING INDEX FOR VIDEOS
			    	$_indexFiles = '\runtime\search';
			        $index = Zend_Search_Lucene::create($_indexFiles);
			        $index = new Zend_Search_Lucene(Yii::getPathOfAlias('application.' . $this->_indexFiles), true);
			    	$index = new Zend_Search_Lucene($this->_indexFiles,true);
			    
    	           $posts = Asset::model()->findAll(); //LOADING ASSET MODULE TO SEARCH VIDEOS
    
    	
    	 
    	  foreach($posts as $post){
    		        
    	  	        // GETTING EXTENTION OF FILE
		    		if(($pos=strrpos($post->file,'.'))!==false)
		    			$ext=substr($post->file,$pos+1);
    		
    				//ADDING VIDIO FILES TO SEARCH INDEX 
					    		if ($ext=='mp4'|| $ext=='3gp'|| $ext=='avi')
					    		{
					    			//here creating search document.
					    			$doc = new Zend_Search_Lucene_Document();
					    			$numericalValue = '123456789';
					    			
					    			$doc->addField(Zend_Search_Lucene_Field::Keyword('keyword', $this->numericalValue));
					    			
					    
					    			//here adding a title to search document with file name. 
					    			$doc->addField(Zend_Search_Lucene_Field::Text('title',
					    					CHtml::encode($post->file), 'utf-8')
					    			);
					    			//here adding a name field to search document with assetid.
					    			$doc->addField(Zend_Search_Lucene_Field::Text('name',
					    					CHtml::encode($post->assetId), 'utf-8')
					    			);
					    
					    			//here adding a link to search document with url.
					    			$doc->addField(Zend_Search_Lucene_Field::Text('link',
					    					CHtml::encode($post->url)
					    					, 'utf-8')
					    			);
					    
					    			//here adding a link to search document with file name. 
					    			$doc->addField(Zend_Search_Lucene_Field::Text('content',
					    					CHtml::encode($post->file)
					    					, 'utf-8')
					    			);
					    
					    
					    			//adding search document to index. 
					    			$index->addDocument($doc);
					    		}
					    
    	    }
    	    
                       //here search index for search is commited.
                        $index->commit();
				    	echo 'Lucene index created';
    
    
    
    }
     
    /*
     * 
    	HERE SEARCH ACTION TO SEARCH FOR AUDIO FILE...
     *
     */
     public function actionSearch3()
    {
				    	// LOADING INDEX FOR AUDIO SEARCH 
				    	$flag=3;
				    	$this->layout='column2';
				        $_indexFiles = '\runtime\search';
				        //creating a index for document.
				        $index = Zend_Search_Lucene::create($_indexFiles);
				        $index = new Zend_Search_Lucene(Yii::getPathOfAlias('application.' . $this->_indexFiles), true);
				    	$index = new Zend_Search_Lucene($this->_indexFiles,true);
				    	$this->layout='column2';
				    	
				    	//GETTING PARAMETER TO SEARCH IN AUDIO, HAVE WORD FOR SEARC THEN SEARCH 
				    
				    	if ((($term = Yii::app()->getRequest()->getParam('param', null)) !== null)) {
				    		
				    		//here calling a create() method for creating search document.
				             $this->actionCreate3();
				    
				             //here opening a search index
				    		$index = Zend_Search_Lucene::open($_indexFiles);
				    		
				    	//here  getting a results for given searc term.
				    		$results = $index->find($term);
				    		$query = Zend_Search_Lucene_Search_QueryParser::parse($term,'utf-8');
				    		 
				    		$this->render('search',compact('results', 'term', 'query','flag'));
				    	}
    
    
    }
    
    /**
    HERE CREATED ACTION TO CREATE SEARCH INDEX FOR AUDIO FILES
     * 
     */
    
    public function actionCreate3()
    {
    				//CREATING INDEX FOR AUDIOS FILES.
			    	$_indexFiles = '\runtime\search';
			    	//here calling  create() search index to create search index.
			        $index = Zend_Search_Lucene::create($_indexFiles);
			        $index = new Zend_Search_Lucene(Yii::getPathOfAlias('application.' . $this->_indexFiles), true);
			    	$index = new Zend_Search_Lucene($this->_indexFiles,true);
    
    				$posts = Asset::model()->findAll(); //LOADING ASSET MODULE TO SEARCH FOR AUDIOS
    
    
    	 
    		foreach($posts as $post){
    		
							// GETTING EXTENTION OF FILE
							
				    		if(($pos=strrpos($post->file,'.'))!==false)
				    			$ext=substr($post->file,$pos+1);
				    		
    		                //ADDING AUDIO FILE INTO SEARCH INDEX
				    		if ($ext==='mp3')
				    		{
				    			$doc = new Zend_Search_Lucene_Document();//here creating an instance of zend lucene search.
				    			
				    			
				              //here adding verious field search document  for search. 
				    			$doc->addField(Zend_Search_Lucene_Field::Text('title',
				    					CHtml::encode($post->file), 'utf-8')
				    			);
				    			$numericalValue = '123456789';
				    			
				    			$doc->addField(Zend_Search_Lucene_Field::Keyword('keyword', $this->numericalValue));
				    			
				    			
				    			//here adding name field to search document with asset id
				    			$doc->addField(Zend_Search_Lucene_Field::Text('name',
				    					CHtml::encode($post->assetId), 'utf-8')
				    			);
				    
				    			//here adding link to search document with url
				    			$doc->addField(Zend_Search_Lucene_Field::Text('link',
				    					CHtml::encode($post->url)
				    					, 'utf-8')
				    			);
				    
				    			//here adding content to search document with file 
				    			$doc->addField(Zend_Search_Lucene_Field::Text('content',
				    					CHtml::encode($post->file)
				    					, 'utf-8')
				    			);
				    
				    
				    			//here adding document to search index.
				    			$index->addDocument($doc);
				    		}
				    
    	       }
    
    
    
    				//	HERE COMMIT THE SEARCH INDEX.
			    	$index->commit();
			    	echo 'Lucene index created';
			    
   }
     
   
    
    
  }
  

 ?>