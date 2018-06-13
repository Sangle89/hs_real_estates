<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Upload extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url', 'file','functions'));
    }

    public function index() {
        $this->load->view('admin/upload', array('error' => ''));
    }

    public function do_upload($file_name='') {
        $upload_path_url = base_url() . 'public/uploads/images/';

        $config['upload_path'] = FCPATH . 'public/uploads/images/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif|JPEG|JPG|PNG|GIF';
        $config['max_size'] = '3000000';
        $config['max_width'] = '5000';
        $config['max_height'] = '5000';

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload($file_name)) {
            //$error = array('error' => $this->upload->display_errors());
            //$this->load->view('upload', $error);
            echo $this->upload->display_errors();
            //$response['error'] = $this->upload->display_errors();
            //echo json_encode($response);
            
            //Load the list of existing files in the upload directory
            $existingFiles = get_dir_file_info($config['upload_path']);
            $foundFiles = array();
            $f=0;
            foreach ($existingFiles as $fileName => $info) {
              if($fileName!='thumbs'){//Skip over thumbs directory
                //set the data for the json array   
                $foundFiles[$f]['name'] = $fileName;
                $foundFiles[$f]['size'] = $info['size'];
                $foundFiles[$f]['url'] = $upload_path_url . $fileName;
                $foundFiles[$f]['thumbnailUrl'] = $upload_path_url . 'thumbs/' . $fileName;
                $foundFiles[$f]['deleteUrl'] = base_url() . ADMIN_FOLDER . '/upload/deleteImage/' . $fileName;
                $foundFiles[$f]['deleteType'] = 'DELETE';
                $foundFiles[$f]['error'] = null;

                $f++;
              }
            }
          //  $this->output
          //  ->set_content_type('application/json')
          //  ->set_output(json_encode(array('files' => $foundFiles)));
        } else {
            $data = $this->upload->data();
            
            // to re-size for thumbnail images un-comment and set path here and in json array
            $config = array();
            $config['image_library'] = 'gd2';
            $config['source_image'] = $data['full_path'];
            $config['create_thumb'] = TRUE;
            $config['new_image'] = $data['file_path'] . 'thumbs/';
            $config['maintain_ratio'] = TRUE;
            $config['thumb_marker'] = '';
            $config['width'] = 75;
            $config['height'] = 50;
            $this->load->library('image_lib', $config);
            $this->image_lib->resize();
            
            //_Resize_Img($data['full_path'], $data['full_path'], 500, 500);
			_Resize_Crop_Img($data['full_path'], $data['file_path'].'thumbs/'.$data['file_name'], 300,300);

            //set the data for the json array
            $info = new StdClass;
            $info->name = $data['file_name'];
            $info->size = $data['file_size'] * 1024;
            $info->type = $data['file_type'];
            $info->url = $upload_path_url . $data['file_name'];
            // I set this to original file since I did not create thumbs.  change to thumbnail directory if you do = $upload_path_url .'/thumbs' .$data['file_name']
            $info->thumbnailUrl = $upload_path_url . 'thumbs/' . $data['file_name'];
            $info->deleteUrl = base_url() . ADMIN_FOLDER . '/upload/deleteImage/' . $data['file_name'];
            $info->deleteType = 'DELETE';
            $info->error = null;

            $files[] = $info;
            //this is why we put this in the constants to pass only json data
            if (IS_AJAX) {
                echo json_encode(array("files" => $files));
                //this has to be the only data returned or you will get an error.
                //if you don't give this a json array it will give you a Empty file upload result error
                //it you set this without the if(IS_AJAX)...else... you get ERROR:TRUE (my experience anyway)
                // so that this will still work if javascript is not enabled
            } else {
              //  $file_data['upload_data'] = $this->upload->data();
              //  $this->load->view('upload/upload_success', $file_data);
            }
        }
    }

    public function deleteImage($file) {//gets the job done but you might want to add error checking and security
        $success = @unlink(FCPATH . 'public/uploads/images/' . $file);
        $success = @unlink(FCPATH . 'public/uploads/images/thumbs/' . $file);
        //info to see if it is doing what it is supposed to
        $info = new StdClass;
        $info->sucess = $success;
        $info->path = base_url() . 'public/uploads/images/' . $file;
        $info->file = is_file(FCPATH . 'public/uploads/images/' . $file);

        if (IS_AJAX) {
            //I don't think it matters if this is set but good for error checking in the console/firebug
            echo json_encode(array($info));
        } else {
            //here you will need to decide what you want to show for a successful delete        
            $file_data['delete_data'] = $file;
            $this->load->view('admin/delete_success', $file_data);
        }
    }
    
    function do_upload2() {
        $upload_path_url = base_url() . 'public/uploads/images/';

        $config['upload_path'] = FCPATH . 'public/uploads/images/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size'] = '3000000';

        $this->load->library('upload', $config);

        // to re-size for thumbnail images un-comment and set path here and in json array
        if($this->upload->do_upload('files')) {
            $data = $this->upload->data();
            $config = array();
            $config['image_library'] = 'gd2';
            $config['source_image'] = $data['full_path'];
            $config['create_thumb'] = TRUE;
            $config['new_image'] = $data['file_path'] . 'thumbs/';
            $config['maintain_ratio'] = TRUE;
            $config['thumb_marker'] = '';
            $config['width'] = 75;
            $config['height'] = 50;
            $this->load->library('image_lib', $config);
            $this->image_lib->resize();
            
            _Resize_Img($data['full_path'], $data['full_path'], 500, 500);
			_Resize_Img($data['full_path'], $data['file_path'].'thumbs/'.$data['file_name'], 250, 250);

            //set the data for the json array
            $info = new StdClass;
            $info->name = $data['file_name'];
            $info->size = $data['file_size'] * 1024;
            $info->type = $data['file_type'];
            $info->url = $upload_path_url . $data['file_name'];
            // I set this to original file since I did not create thumbs.  change to thumbnail directory if you do = $upload_path_url .'/thumbs' .$data['file_name']
            $info->thumbnailUrl = $upload_path_url . 'thumbs/' . $data['file_name'];
            $info->deleteUrl = base_url() . 'admin/upload/deleteImage/' . $data['file_name'];
            $info->deleteType = 'DELETE';
            $info->success = 1;
            
            
            echo json_encode($info);
            
        }else{
            $info = new StdClass;
            $info->success = 0;
            echo json_encode($info);
        }
            
    }

}