<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Excel extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
        $this->load->model('master/People_model');
        $this->load->library('Token_Validation');
    }

    private function extract_user($token)
    {
        $data_token = $this->token_validation->extract($token);
        $i_user = $data_token['i_user'];
        return $i_user;
    }

    public function upload_people(){
        // get uploader
        $i_user = $this->extract_user($this->session->userdata('id_token'));
        
        $fileName = time().$_FILES['file']['name'];
         
        $config['upload_path'] = './assets/data_excel/'; //buat folder dengan nama assets di root folder
        $config['file_name'] = $fileName;
        $config['allowed_types'] = 'xls|xlsx|csv';
        $config['max_size'] = 10000;
         
        $this->load->library('upload');
        $this->upload->initialize($config);
         
        if(! $this->upload->do_upload('file') )
        $this->upload->display_errors();
             
        $media = $this->upload->data('file');
        $inputFileName = './assets/data_excel/'.$config['file_name'];
         
        try {
            $inputFileType = IOFactory::identify($inputFileName);
            $objReader = IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFileName);
        } catch(Exception $e) {
            die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
        }
 
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
            
        for ($row = 2; $row <= $highestRow; $row++){                  
            //  Read a row of data into an array                 
            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
            if ($rowData[0][1] != null AND $rowData[0][2] != null) {
                //Sesuaikan sama nama kolom tabel di database                                
                $data = array(
                    "c_people"      => $rowData[0][0],
                    "n_people"      => $rowData[0][1],
                    "type_people"   => 'employee',
                    "c_company"     => $rowData[0][2],
                    "email"         => $rowData[0][3],
                    "phone"         => $rowData[0][4],
                    "b_active"      => 't',
                    "e_entry"       => $i_user,
                    "card_active"   => null
                );
                    
                //sesuaikan nama dengan nama tabel
                $insert = $this->People_model->save($data);                  
                delete_files($config['upload_path']);

                $data['status'] = TRUE;
            }                                                
        }

        redirect(base_url('employee'));
    }
}

/* End of file Excel.php */
