<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Card_Management extends CI_Controller {

    function __construct(){
        parent::__construct();
        require_once APPPATH.'third_party/PHPExcel.php';

        $this->load->model('master/Card_model');
        $this->load->model('general/Menu_model');
        $this->load->library('Token_Validation');
    }

    private function extract_user($token)
    {
        $data_token = $this->token_validation->extract($token);
        $i_user = $data_token['i_user'];
        return $i_user;
    }

    public function get_json()
    {
        $output = null;
        $token = $this->session->userdata('id_token');
        
        if($token){
            
            //cek validasi token
            if($this->token_validation->check($token)){

                $list = $this->Card_model->get_datatables();
                $data = array();
                $no = $_POST['start'];
                foreach ($list as $field) {
                    
                    if ($field->b_active == 't') {
                        $b_active = '<span class="badge badge-success badge-roundless"><i class="fa fa-check"></i> active</span>';
                    }else{
                        $b_active = '<span class="badge badge-danger badge-roundless"><i class="fa fa-check"></i> non active</span>';
                    }

                    $no++;
                    $row = array();
                    $row[] = $no;
                    $row[] = $field->c_card;
                    $row[] = $field->i_card_type;
                    $row[] = $field->c_people;
                    $row[] = $field->d_active_card; 
                    $row[] = $b_active;            
                    
                    $data[] = $row;
                }
        
                $output = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $this->Card_model->count_all(),
                    "recordsFiltered" => $this->Card_model->count_filtered(),
                    "data" => $data,
                );
            }
        }
        //output dalam format JSON
        echo json_encode($output);
    }

    public function all()
    {
        // call function
        $this->get_json();
    }

    public function show()
    {
        $token = $this->session->userdata('id_token');
        $n_menu = "card";
        
        if($token){
            
            //cek validasi token
            if($this->token_validation->check($token)){
                
                $data = array(  
                    'menu'          => 'Card', 
                    'title'         => 'Card Management', 
                    'subtitle'      => 'Pages',
                    'table_title'   => 'Card List'
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

                $data['card'] = $this->Card_model->show_data_card();
                $data['card_type'] = $this->Card_model->show_card_type();

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

        $data['menu'] = 'Card';
        
        $this->load->template('management/v_card', $data);
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
                $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFont()->setBold(true);

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

                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);

                //set Sheet yang akan diolah 
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A1', 'No')
                        ->setCellValue('B1', 'Card Number')
                        ->setCellValue('C1', 'Card Type')
                        ->setCellValue('D1', 'Card Owner')
                        ->setCellValue('E1', 'Active')
                        ->setCellValue('F1', 'Status');
                        
                $list = $this->Card_model->exportExcel($_POST['i_card_type']);
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
                    $objPHPExcel->getActiveSheet()->getStyle('C'.$i)->applyFromArray($style_center);
                    $objPHPExcel->getActiveSheet()->getStyle('D'.$i)->applyFromArray($style_center);
                    $objPHPExcel->getActiveSheet()->getStyle('E'.$i)->applyFromArray($style_center);
                    $objPHPExcel->getActiveSheet()->getStyle('F'.$i)->applyFromArray($style_center);

                   $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$i, $no++);
                   $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$i, $field->c_card);
                   $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$i, $field->i_card_type);
                   $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$i, $field->c_people);
                   $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$i, $field->d_active_card);
                   $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$i, $b_active);
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
                header('Content-Disposition: attachment;filename="CardList.xlsx"');
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

/* End of file Card_Management.php */
