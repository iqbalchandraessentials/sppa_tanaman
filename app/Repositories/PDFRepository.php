<?php

namespace App\Repositories;

use Elibyy\TCPDF\Facades\TCPDF;

use PDF;

class PDFRepository extends PDF
{
    protected $pdf = "";

    public function __construct()
    {
        $pdf = new  TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);

        $this->pdf = $pdf;


        // Custom Footer
        $this->pdf::setFooterCallback(function ($pdf) {

            // Position at 15 mm from bottom
            $pdf->SetY(-20);
            $pdf->SetX(-5);
            // Set font
            $pdf->SetFont('helvetica', 'I', 5);
            // Page number
            $pdf->Cell(0, 20, 'Hal ' . $pdf->getAliasNumPage() . ' dari ' . $pdf->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        });
        $this->pdf::SetAuthor('BangtiraySoft');
        $this->pdf::SetTopMargin(40);
        $this->pdf::setRightMargin(10);
        $this->pdf::setLeftMargin(10);

        $this->pdf::setFooterMargin(22);
        $this->pdf::SetFont('dejavusans', '', 9, '', true);
        $this->pdf::SetHeaderMargin(5);
        $this->pdf::SetAutoPageBreak(true, 20);
        $this->pdf::SetDisplayMode('real', 'default');
    }

    public function header()
    {
        $this->pdf::SetFont('helvetica', '', 9); // default font header
        $this->pdfwriteHTMLCell(
            $w = 0,
            $h = 0,
            $x = '',
            $y = '',
            $this->header,
            $border = 0,
            $ln = 1,
            $fill = 0,
            $reseth = true,
            $align = 'top',
            $autopadding = true
        );
        $posisi_y = $this->getY();
        $this->pdf::SetTopMargin($posisi_y - 3);
    }

    public function setReleaseBackground()
    {
        $this->pdf::setHeaderCallback(function ($pdf) {
            $bMargin = $pdf->getBreakMargin();
            $auto_page_break = $pdf->getAutoPageBreak();
            $pdf->SetAutoPageBreak(false, 22);
            $img_file = K_PATH_IMAGES . 'kop.jpeg';
            $pdf->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, true, 0);
            $pdf->SetAutoPageBreak($auto_page_break, $bMargin);
            $pdf->setPageMark();
        });
    }

    public function setUnReleaseBackground()
    {
        $this->pdf::setHeaderCallback(function ($pdf) {
            $bMargin = $pdf->getBreakMargin();
            $auto_page_break = $pdf->getAutoPageBreak();
            $pdf->SetAutoPageBreak(false, 22);
            $img_file = K_PATH_IMAGES . 'draft.png';
            $pdf->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, true, 0);
            $pdf->SetAutoPageBreak($auto_page_break, $bMargin);
            $pdf->setPageMark();
        });
    }

    public function setTitle($top = 0, $title = "", $align = "")
    {
        $this->pdf::Write($top, $title, '', 0, $align, true, 0, false, false, 30);
    }
    public function labelTitle($title = "")
    {
        $this->pdf::SetTitle($title);
    }
    public function setLine($val = 0)
    {
        $this->pdf::ln($val);
    }
    public function setOutputName($fileName = "", $mode = "")
    {
        $this->pdf::Output($fileName . ".pdf", $mode);
    }
    public function setFonts($font = "", $style = "", $size = 0)
    {
        $this->pdf::SetFont($font, $style, $size, '', true);
    }
    public function writeContent($content = "")
    {
        $this->pdf::writeHtml($content, true, false, true, false, '');
    }
    public function set_header()
    {
        $img_file = K_PATH_IMAGES . 'jastan_logo.png';
        $header = '<style>
                    .h_tengah {text-align: center;}
                    .h_kiri {text-align: left;}
                    .h_kanan {text-align: right;}
                    .txt_judul {font-size: 12pt; font-weight: bold; padding-bottom: 12px;}
                    .header_kolom {background-color: #c2a0eb; text-align: center; font-weight: bold;}
                </style>
            <table style="width:100%;">
                    <tr>
                        <td style="width:35%;"><img src="' . $img_file . '" width="150"></td>
                         <td style="width:65%;"><strong style="font-size: 15px;"> PT ASURANSI JASA TANIA, Tbk</strong> <br>

                            <table>

                                <tr>
                                    <td><font style="font-size: 10px;">Gedung Agro Plaza Lantai 9</font></td>
                                </tr>
								<tr>
                                    <td><font style="font-size: 10px;">Jl. HR. Rasuna Said Kav. X2 No.1 Jakarta 12950</font></td>
                                </tr>
                                <tr>
                                    <td><font style="font-size: 10px;">Telp. 021-526 2529 Fax.  526 2539/5262540</font></td>
                                </tr>
                                <tr>
                                    <td><font style="font-size: 10px;">Homepage : www.jastan.co.id</font></td>
                                </tr>
                            </table>
                         </td>
                     </tr>
                </table>
                <br></br><br></br>';

        // $this->header = $header;

        $this->pdf::SetFont('helvetica', '', 9); // default font header
        // $this->pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
        $this->pdf::writeHTMLCell(
            $w = 0,
            $h = 0,
            $x = '',
            $y = '',
            $header,
            $border = 0,
            $ln = 1,
            $fill = 0,
            $reseth = true,
            $align = 'top',
            $autopadding = true
        );
        // $posisi_y =$this->pdf::getY();
        // $this->pdf::pdfSetTopMargin($posisi_y - 3);

    }
    public function create_bc($param)
    {

        $style = array(
            'position' => '',
            'align' => 'R',
            'stretch' => false,
            'fitwidth' => true,
            'cellfitalign' => '',
            'border' => false,
            'padding' => 0,
            'fgcolor' => array(0, 0, 0),
            'bgcolor' => false, //array(255,255,255),
            'text' => true,
            'font' => 'tahoma',
            'fontsize' => 8,
            'stretchtext' => 4,
        );

        // $this->pdf->write1DBarcode($param, 'C93', '', '', '', 18, 0.4, $style, 'N');
        $this->pdf::write2DBarcode($param, 'QRCODE,H', '', '', 20, 20, $style, 'N');
        // $this->pdf::write2DBarcode($param, 'QRCODE,H',140, 210, 50, 50, $style, 'N');

    }

    public function addPage()
    {
        $this->pdf::AddPage();
    }

    public function setFooter($text, $align = null)
    {

        $this->pdf::Cell(0, 0, $text);
    }
}
