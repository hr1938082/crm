<?php
/**
* Phpmailer Class
*/
use Dompdf\Dompdf;
class Pdf
{
	public $tcpdf;
	public function __construct()
	{
		require DIR_BUILDER.'libs/dompdf/src/Autoloader.php';
		// reference the Dompdf namespace
		
		// instantiate and use the dompdf class
		$dompdf = new Dompdf();
		$dompdf->loadHtml('hello world');

		// (Optional) Setup the paper size and orientation
		$dompdf->setPaper('A4', 'landscape');

		// Render the HTML as PDF
		$dompdf->render();

		// Output the generated PDF to Browser
		$dompdf->stream();

	}
}