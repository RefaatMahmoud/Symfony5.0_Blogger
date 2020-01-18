<?php

namespace App\Service;

use Dompdf\Dompdf;
use Dompdf\Options;

class PDF
{
    public function getPrint($html, $download = false): void
    {
        $pdfOptions = $this->setOptions();
        $dompdf = new Dompdf($pdfOptions);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("file.pdf", [
            "Attachment" => $download
        ]);
    }

    /**
     * @return Options
     */
    private function setOptions(): Options
    {
        $pdfOptions = new Options();
        $pdfOptions->set('isRemoteEnabled', true);
        $pdfOptions->set('defaultFont', 'Arial');
        return $pdfOptions;
    }
}
