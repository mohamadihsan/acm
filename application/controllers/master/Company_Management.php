<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Company_Management extends CI_Controller {

    function __construct(){
        parent::__construct();
        require_once APPPATH.'third_party/PHPExcel.php';
        
        $this->load->model('master/Company_model');
        $this->load->model('general/Menu_model');
        $this->load->library('Token_Validation');
    }

    private function extract_user($token)
    {
        $data_token = $this->token_validation->extract($token);
        $i_user = $data_token['i_user'];
        return $i_user;
    }

    public function get_json($n_menu)
    {
        $output = null;
        $token = $this->session->userdata('id_token');
        
        if($token){
            
            //cek validasi token
            if($this->token_validation->check($token)){

                // BEGIN
                // INCLUDE THIS SCRIPT TO SET USER ROLE
                // get user role 
                $data_token = $this->token_validation->extract($token);
                $i_group_from_token = $data_token['i_group'];

                // show user role for action this menu
                $action = $this->Menu_model->check_action($i_group_from_token, $n_menu);
                $view   = $action[0]->b_view;
                $insert = $action[0]->b_insert;
                $update = $action[0]->b_update;
                $delete = $action[0]->b_delete;

                
                
                //  END SCRIPT TO SET USER ROLE

                $list = $this->Company_model->get_datatables();
                $data = array();
                $no = $_POST['start'];
                foreach ($list as $field) {
                    
                    $no++;
                    $row = array();
                    $row[] = $no;
                    $row[] = $field->c_company;
                    $row[] = $field->n_company;
                    $row[] = $field->address;    
                    
                    if ($update == 't' AND $delete == 't') {
                        $row[] = '  <button type="button" class="btn btn-warning btn-sm" onclick="edit_data('."'".$field->i_company."'".')"><i class="fa fa-pencil"></i> edit</button>
                                <button type="button" class="btn btn-danger btn-sm" onclick="delete_data('."'".$field->i_company."'".')"><i class="fa fa-trash"></i> delete</button>';
                    }else if ($update == 't' AND $delete == 'f' OR $delete == null) {
                        $row[] = '  <button type="button" class="btn btn-warning btn-sm" onclick="edit_data('."'".$field->i_company."'".')"><i class="fa fa-pencil"></i> edit</button>';
                    }else if ($update == 'f' OR $update == null AND $delete == 't') {
                        $row[] = '  <button type="button" class="btn btn-danger btn-sm" onclick="delete_data('."'".$field->i_company."'".')"><i class="fa fa-trash"></i> delete</button>';
                    }else{
                        $row[] = '';
                    }
                    
                    $data[] = $row;
                }
        
                $output = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $this->Company_model->count_all(),
                    "recordsFiltered" => $this->Company_model->count_filtered(),
                    "data" => $data,
                );
            }
        }
        
        //output dalam format JSON
        echo json_encode($output);
    }

    public function all()
    {
        // menu name must pair with n_menu on macm.t_m_menu
        $n_menu = 'company';

        // call function
        $this->get_json($n_menu);
    }

    public function show()
    {
        $token = $this->session->userdata('id_token');
        $n_menu = 'company';
        
        if($token){
            
            //cek validasi token
            if($this->token_validation->check($token)){
                
                $data = array(  
                    'menu'          => 'Company / Department / Station', 
                    'title'         => 'Company / Department / Station Management', 
                    'subtitle'      => 'Pages',
                    'table_title'   => 'Company / Department / Station List'
                );

                // get user role
                $data_token = $this->token_validation->extract($token);
                $i_group_from_token = $data_token['i_group'];

                // show menu based on group user
                $data['menu_single'] = $this->Menu_model->show_menu_user($i_group_from_token, null);
                $data['menu_master'] = $this->Menu_model->show_menu_user($i_group_from_token, 'master');
                $data['menu_card_owner'] = $this->Menu_model->show_menu_user($i_group_from_token, 'card owner');
                $data['menu_report_transaction'] = $this->Menu_model->show_menu_user($i_group_from_token, 'report transaction');
                
                $roles = $this->Menu_model->check_action($i_group_from_token, $n_menu);
                $data['view']   = $roles[0]->b_view;
                $data['insert'] = $roles[0]->b_insert;

                $data['company'] = $this->Company_model->show_data_company();

            }else{

                // token expired        
                ?>  
                    <script> 
                        setTimeout(function(){
                            alert("Token is expired. System will be logout automatically!")
                        }, 1000);
                    </script> 
                <?php

                redirect('logout','refresh');
                
            } 

        }else{

            // redirect logout, token not found    
            ?>  
                <script> 
                    setTimeout(function(){
                        alert("You do not have access to this page!")
                    }, 1000);
                </script> 
            <?php

            redirect('logout','refresh');
            
        } 

        $data['menu'] = 'Company';
        
        $this->load->template('management/v_company', $data);
    }

    public function ajax_edit($id)
    {
        $data = $this->Company_model->get_by_id($id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();
        // get user entry
        $i_user = $this->extract_user($this->session->userdata('id_token'));

        $data = array(
                'c_company' => $this->input->post('c_company'),
                'n_company' => $this->input->post('n_company'),
                'address'   => $this->input->post('address'),
                'e_entry' => $i_user
            );
        $insert = $this->Company_model->save($data);
        
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate();
        // get user entry
        $i_user = $this->extract_user($this->session->userdata('id_token'));
        
        $data = array(
                'c_company' => $this->input->post('c_company'),
                'n_company' => $this->input->post('n_company'),
                'address'   => $this->input->post('address'),
                'e_entry' => $i_user
            );
        $this->Company_model->update(array('i_company' => $this->input->post('i_company')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id)
    {
        $this->Company_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
 
 
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('c_company') == '')
        {
            $data['inputerror'][] = 'c_company';
            $data['error_string'][] = 'Company Code is required';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('n_company') == '')
        {
            $data['inputerror'][] = 'n_company';
            $data['error_string'][] = 'Company Name is required';
            $data['status'] = FALSE;
        }
 
        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }

    function exportExcel()
    {
        $token = $this->session->userdata('id_token');
        
        if($token){
            
            //cek validasi token
            if($this->token_validation->check($token)){

                //membuat objek PHPExcel
                $objPHPExcel = new PHPExcel();
                
                $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(25);
                //change the font size
                $objPHPExcel->getActiveSheet()->getStyle('A:F')->getFont()->setSize(10);
                //make the font become bold
                $objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getFont()->setBold(true);

                $style_header = array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        // 'color' => array('rgb' => 'CCCCCC'),
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    ),
                    'font' => array(
                        'bold' => true,
                    )
                );

                $style_table_header = array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'EEEEEE')
                    ),
                    'borders' => array(
                        'outline' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('argb' => '000000'),
                        ),
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    ),
                      'font' => array(
                          'bold' => true,
                    )
                );
            
                $style_center = array(
                    'borders' => array(
                        'outline' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('argb' => '000000'),
                        ),
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    )
                );
            
                $style_right = array(
                    'borders' => array(
                        'outline' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('argb' => '000000'),
                        ),
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    )
                );
            
                $style_left = array(
                    'borders' => array(
                        'outline' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('argb' => '000000'),
                        ),
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    )
                );
            
                $style_left_bold = array(
                    'font' => array('bold' => true,
                    ),
                    'borders' => array(
                        'outline' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('argb' => '000000'),
                        ),
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    )
                );
            
                $style_right_bold = array(
                    'font' => array('bold' => true,
                    ),
                    'borders' => array(
                        'outline' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('argb' => '000000'),
                        ),
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    )
                );
            
                $style_border = array(
                    'borders' => array(
                        'outline' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('argb' => '000000'),
                        ),
                    )
                );
            
                $style_bold = array(
                    'font' => array('bold' => true,
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    )
                );
                
                // Top
                $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($style_table_header);
                $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($style_table_header);
                $objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($style_table_header);
                $objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($style_table_header);

                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);

                //set Sheet yang akan diolah 
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A1', 'No')
                        ->setCellValue('B1', 'Code')
                        ->setCellValue('C1', 'Name')
                        ->setCellValue('D1', 'Address');
                        
                $list = $this->Company_model->exportExcel();
                $no = 1;
                $i = 2;
                foreach ($list as $field) {      
                   
                    // Style Content
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$i)->applyFromArray($style_center);
                    $objPHPExcel->getActiveSheet()->getStyle('B'.$i)->applyFromArray($style_center);
                    $objPHPExcel->getActiveSheet()->getStyle('C'.$i)->applyFromArray($style_left);
                    $objPHPExcel->getActiveSheet()->getStyle('D'.$i)->applyFromArray($style_left);

                   $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$i, $no++);
                   $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$i, $field->c_company);
                   $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$i, $field->n_company);
                   $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$i, $field->address);
                   $i++;
                }
                
                //mulai menyimpan excel format xlsx, kalau ingin xls ganti Excel2007 menjadi Excel5          
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
                
                // Set document properties
                $objPHPExcel->getProperties()->setCreator("Nutech Integrasi")
                            ->setLastModifiedBy("Nutech Integrasi")
                            ->setTitle("Company, Department, Station List")
                            ->setSubject("Company, Department, Station List")
                            ->setDescription("Generate Company, Department, Station List.")
                            ->setKeywords("Company, Department, Station")
                            ->setCategory("Report");

                //sesuaikan headernya 
                header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
                header("Cache-Control: no-store, no-cache, must-revalidate");
                header("Cache-Control: post-check=0, pre-check=0", false);
                header("Pragma: no-cache");
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                //ubah nama file saat diunduh
                header('Content-Disposition: attachment;filename="List.xlsx"');
                //unduh file
                $objWriter->save("php://output");
            }
        }else{
            // token expired        
            ?>  
            <script> 
                setTimeout(function(){
                    alert("Token is expired. System will be logout automatically!")
                }, 1000);
            </script> 
            <?php

            redirect('logout','refresh');
        }
    }
}

/* End of file Company_Management.php */
