<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class People_Management extends CI_Controller {

    function __construct(){
        parent::__construct();
        require_once APPPATH.'third_party/PHPExcel.php';

        $this->load->model('master/People_model');
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

    public function get_json($type_people, $n_menu)
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

                $list = $this->People_model->get_datatables($type_people);
                $data = array();
                $no = $_POST['start'];
                foreach ($list as $field) {
                    
                    if ($field->b_active == 't') {
                        $b_active = '<span class="badge badge-success badge-roundless"><i class="fa fa-check"></i> active</span>';
                    }else{
                        $b_active = '<span class="badge badge-danger badge-roundless"><i class="fa fa-check"></i> non active</span>';
                    }

                    if ($field->card_active != null) {
                        $days = 'days';
                    }else{
                        $days = '-';
                    }

                    if ($field->email == null) {
                        $field->email = '-';
                    }

                    if ($field->phone == null) {
                        $field->phone = '-';
                    }
                    
                    $no++;
                    $row = array();
                    $row[] = $no;
                    $row[] = $field->c_people;
                    $row[] = $field->n_people;
                    $row[] = $field->n_company;
                    $row[] = $field->email;
                    $row[] = $field->phone;
                    $row[] = $b_active;
                    $row[] = $field->card_active.' '.$days;

                    if ($update == 't' AND $delete == 't') {
                        $row[] = '  <button type="button" class="btn btn-warning btn-sm" onclick="edit_data('."'".$field->i_people."'".')"><i class="fa fa-pencil"></i> edit</button>
                        <button type="button" class="btn btn-danger btn-sm" onclick="delete_data('."'".$field->i_people."'".')"><i class="fa fa-trash"></i> delete</button>';
                    }else if ($update == 't' AND $delete == 'f' OR $delete == null) {
                        $row[] = '  <button type="button" class="btn btn-warning btn-sm" onclick="edit_data('."'".$field->i_people."'".')"><i class="fa fa-pencil"></i> edit</button>';
                    }else if ($update == 'f' OR $update == null AND $delete == 't') {
                        $row[] = '  <button type="button" class="btn btn-danger btn-sm" onclick="delete_data('."'".$field->i_people."'".')"><i class="fa fa-trash"></i> delete</button>';
                    }else{
                        $row[] = '';
                    }
        
                    $data[] = $row;
                }
        
                $output = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $this->People_model->count_all($type_people),
                    "recordsFiltered" => $this->People_model->count_filtered($type_people),
                    "data" => $data,
                );
            }
        }

        //output dalam format JSON
        echo json_encode($output);
    }

    public function all_employee()
    {
        // menu name must pair with n_menu on macm.t_m_menu
        $n_menu = 'kci employee';
        $type_people = 'employee';
        // call function
        $this->get_json($type_people, $n_menu);
    }

    public function all_tenant()
    {
        // menu name must pair with n_menu on macm.t_m_menu
        $n_menu = 'tenant / vendor';
        $type_people = 'tenant';
        // call function
        $this->get_json($type_people, $n_menu);
    }

    public function all_non_employee()
    {
        // menu name must pair with n_menu on macm.t_m_menu
        $n_menu = 'non kci';
        $type_people = 'non employee';
        // call function
        $this->get_json($type_people, $n_menu);
    }

    public function all_master()
    {
        // menu name must pair with n_menu on macm.t_m_menu
        $n_menu = 'master';
        $type_people = 'master';
        // call function
        $this->get_json($type_people, $n_menu);
    }

    public function show_employee()
    {
        $token = $this->session->userdata('id_token');
        $n_menu = "kci employee";

        if($token){
            
            //cek validasi token
            if($this->token_validation->check($token)){
                
                $data = array(  
                    'menu'          => 'KCI Employee', 
                    'title'         => 'Employee Management', 
                    'subtitle'      => 'Pages',
                    'table_title'   => 'Employee List'
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

        $data['menu'] = 'Employee';
        
        $this->load->template('management/v_employee', $data);
    }

    public function show_tenant()
    {
        $token = $this->session->userdata('id_token');
        $n_menu = "tenant / vendor";

        if($token){
            
            //cek validasi token
            if($this->token_validation->check($token)){
                
                $data = array(  
                    'menu'          => 'Tenant', 
                    'title'         => 'Tenant Management', 
                    'subtitle'      => 'Pages',
                    'table_title'   => 'Tenant List'
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
        
        $data['menu'] = 'Tenant / Vendor';
        $this->load->template('management/v_tenant', $data);
    }

    public function show_non_employee()
    {
        $token = $this->session->userdata('id_token');
        $n_menu = "non kci";

        if($token){
            
            //cek validasi token
            if($this->token_validation->check($token)){
                
                $data = array(  
                    'menu'          => 'Non Employee', 
                    'title'         => 'Non Employee Management', 
                    'subtitle'      => 'Pages',
                    'table_title'   => 'Non Employee List'
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
        
        $data['menu'] = 'Non Employee';

        $this->load->template('management/v_non_employee', $data);
    }

    public function show_master()
    {
        $token = $this->session->userdata('id_token');
        $n_menu = "master";

        if($token){
            
            //cek validasi token
            if($this->token_validation->check($token)){
                
                $data = array(  
                    'menu'          => 'Master Station', 
                    'title'         => 'Master Station Management', 
                    'subtitle'      => 'Pages',
                    'table_title'   => 'Master Station List'
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

        $data['menu'] = 'master';
        
        $this->load->template('management/v_master', $data);
    }

    public function ajax_edit($id)
    {
        $data = $this->People_model->get_by_id($id);
        //$data->email = ($data->email == '0000-00-00') ? '' : $data->email; // if 0000-00-00 set tu empty for datepicker compatibility
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();
        // get user entry
        $i_user = $this->extract_user($this->session->userdata('id_token'));

        $data = array(
                'c_people' => $this->input->post('c_people'),
                'n_people' => $this->input->post('n_people'),
                'type_people' => $this->input->post('type_people'),
                'c_company' => $this->input->post('c_company'),
                'email' => $this->input->post('email'),
                'phone' => $this->input->post('phone'),
                'b_active' => 't',
                'e_entry' => $i_user,
                'card_active' => $this->input->post('card_active'),
            );
        $insert = $this->People_model->save($data);
        
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate();
        // get user entry
        $i_user = $this->extract_user($this->session->userdata('id_token'));
        
        $data = array(
                'c_people' => $this->input->post('c_people'),
                'n_people' => $this->input->post('n_people'),
                'type_people' => $this->input->post('type_people'),
                'c_company' => $this->input->post('c_company'),
                'email' => $this->input->post('email'),
                'phone' => $this->input->post('phone'),
                'b_active' => 't',
                'e_entry' => $i_user,
                'card_active' => $this->input->post('card_active'),
            );
        $this->People_model->update(array('i_people' => $this->input->post('i_people')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id)
    {
        $this->People_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
 
 
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('c_people') == '')
        {
            $data['inputerror'][] = 'c_people';
            $data['error_string'][] = 'Identity Number is required';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('n_people') == '')
        {
            $data['inputerror'][] = 'n_people';
            $data['error_string'][] = 'Name is required';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('type_people') == '')
        {
            $data['inputerror'][] = 'type_people';
            $data['error_string'][] = 'Please select type';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('c_company') == '')
        {
            $data['inputerror'][] = 'c_company';
            $data['error_string'][] = 'Please select Company';
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
                $objPHPExcel->getActiveSheet()->getStyle('A:G')->getFont()->setSize(10);
                //make the font become bold
                $objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);

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
                $objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($style_table_header);
                $objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($style_table_header);
                $objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($style_table_header);

                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(40);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);

                //set Sheet yang akan diolah 
                if ($_POST['type_people'] == 'employee') {
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A1', 'No')
                        ->setCellValue('B1', 'NIK')
                        ->setCellValue('C1', 'Full Name')
                        ->setCellValue('D1', 'Department')
                        ->setCellValue('E1', 'Status')
                        ->setCellValue('F1', 'Email')
                        ->setCellValue('G1', 'Phone');
                }else if ($_POST['type_people'] == 'non_employee' OR $_POST['type_people'] == 'tenant') {
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A1', 'No')
                        ->setCellValue('B1', 'Identity Number')
                        ->setCellValue('C1', 'Full Name')
                        ->setCellValue('D1', 'Company')
                        ->setCellValue('E1', 'Status')
                        ->setCellValue('F1', 'Email')
                        ->setCellValue('G1', 'Phone');
                }else if ($_POST['type_people'] == 'master') {
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A1', 'No')
                        ->setCellValue('B1', 'Identity Number')
                        ->setCellValue('C1', 'Full Name')
                        ->setCellValue('D1', 'Station')
                        ->setCellValue('E1', 'Status')
                        ->setCellValue('F1', 'Email')
                        ->setCellValue('G1', 'Phone');
                }
                
                        
                $list = $this->People_model->exportExcel($_POST['type_people'], $_POST['b_active']);
                $no = 1;
                $i = 2;
                foreach ($list as $field) {
                    
                    if ($field->b_active == 't') {
                        $b_active = 'active';
                    }else{
                        $b_active = 'non active';
                    }         
                   
                    // Style Content
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$i)->applyFromArray($style_center);
                    $objPHPExcel->getActiveSheet()->getStyle('B'.$i)->applyFromArray($style_center);
                    $objPHPExcel->getActiveSheet()->getStyle('C'.$i)->applyFromArray($style_left);
                    $objPHPExcel->getActiveSheet()->getStyle('D'.$i)->applyFromArray($style_left);
                    $objPHPExcel->getActiveSheet()->getStyle('E'.$i)->applyFromArray($style_center);
                    $objPHPExcel->getActiveSheet()->getStyle('F'.$i)->applyFromArray($style_left);
                    $objPHPExcel->getActiveSheet()->getStyle('G'.$i)->applyFromArray($style_center);

                   $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$i, $no++);
                   $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$i, $field->c_people);
                   $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$i, $field->n_people);
                   $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$i, $field->n_company);
                   $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$i, $b_active);
                   $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$i, $field->email);
                   $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$i, $field->phone);
                   $i++;
                }

                // PHPExcel_Shared_Font::setAutoSizeMethod(PHPExcel_Shared_Font::AUTOSIZE_METHOD_EXACT);

                // foreach($objPHPExcel->getActiveSheet()->getColumnDimension() as $col) {
                //     $col->setAutoSize(true);
                // }
                
                //mulai menyimpan excel format xlsx, kalau ingin xls ganti Excel2007 menjadi Excel5          
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
                
                // Set document properties
                $objPHPExcel->getProperties()->setCreator("Nutech Integrasi")
                            ->setLastModifiedBy("Nutech Integrasi")
                            ->setTitle("Card List")
                            ->setSubject("Card List")
                            ->setDescription("Generate Card List.")
                            ->setKeywords("Card")
                            ->setCategory("Report");

                //sesuaikan headernya 
                header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
                header("Cache-Control: no-store, no-cache, must-revalidate");
                header("Cache-Control: post-check=0, pre-check=0", false);
                header("Pragma: no-cache");
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                //ubah nama file saat diunduh
                header('Content-Disposition: attachment;filename="CardOwner.xlsx"');
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

/* End of file People_Management.php */
