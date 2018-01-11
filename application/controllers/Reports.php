<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form','url','html'));
        $this->load->library(array('session', 'form_validation'));
        if (! $this->session->userdata('uid'))
        {
            redirect('login');
        }

        $this->lang->load('common',$this->session->userdata('lang'));
    }

    public function index()
    {
        $data['list']=$this->Allocationinfo->get_reports();
        $data['headers']=$this->Commoninfo->get_headers_reports();
        $this->load->view('reports/view', $data);
    }

    function generate()
    {
        $data['reports']=$this->Allocationinfo->generate();

        $this->session->set_flashdata('msg', $this->lang->line('generate_month_success'));
        redirect('reports');
    }

    function reports_pdf($year,$month,$day)
    {
        $data['reports']=$this->Allocationinfo->get_trans($year,$month,$day);
        $data['headers']=$this->Commoninfo->get_column_pdf();
        $search_date=$year."-".$month."-".$day;
        $data['period']=date('Y-m-d',strtotime($search_date));
        $this->load->view("reports/list",$data);
        $html= $this->load->view("reports/list",$data,true);
        $this->stylesheet = file_get_contents(base_url().'tracker/css/pdf.css');
        //this data will be passed on to the view
        $data['the_content']='mPDF and CodeIgniter are cool!';
        //load the view, pass the variable and do not show it but "save" the output into $html variable
        //$html=$this->load->view('pdf_output', $data, true);
        //this the the PDF filename that user will get to download
        $month=$month+1;
        $report_date=$year."-".$month."-01";
        $year_month=date('F Y',strtotime($report_date));
        $pdfFilePath = "Reports_".$year_month.".pdf";
        //load mPDF library
        $this->load->library('m_pdf');
        //actually, you can pass mPDF parameter on this load() function
        $pdf = $this->m_pdf->load();
        //generate the PDF!


        $pdf->AddPage('L','','','','',10,10,10,10,10,5);
        
$pdf->defaultfooterline=1;
        //$pdf->SetFooter("Footer Page".{PAGE});
        //$pdf->setFooter('{PAGENO}');
        $pdf->setFooter("Page {PAGENO} of {nb}");
        $pdf->WriteHTML($html);
        //offer it to user via browser download! (The PDF won't be saved on your server HDD)
        $pdf->Output($pdfFilePath, 'D');
        //D for download
        //F for Save
    }
}
