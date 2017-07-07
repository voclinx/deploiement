<?php

require_once('tcpdf.php');

class CUSTOM_TCPDF extends TCPDF
{
    // Page footer
    public function Footer()
    {
        $this->SetY(-22);
        $this->SetFont('helvetica', '', 8);


        // Uniquement si != bilan de compétence et VAE
        if (strcasecmp($this->type_demande, 'Bilan de compétences') == 0
            && strcasecmp($this->type_demande, 'VAE') == 0
        ) {

            if (!$this->interne && $this->getPage() == 1) {
                $html = '<p style="border-bottom: solid 1px #000000; "> </p>';
                $this->writeHTMLCell(50, 0, 10, $this->GetY(), $html, 0, 0, 0, 0, 0, 0);
                if ($this->intra) {
                    $text = 'Intra : Uniquement dispensée aux salariés de l\'entreprise';
                } else {
                    $text = 'Inter : Formation dispensée à des salariés de différentes entreprises';
                }
                $this->writeHTMLCell(100, 0, 10, $this->GetY() + 5, '&sup1; ' . $text);
            }
        }

        $this->writeHTMLCell(0, 0, 0, $this->GetY(), 'Page ' . $this->getAliasNumPage() . ' sur ' . trim($this->getAliasNbPages()), 0, 0, 0, 0, 'R', 0);
//     $this->Cell(0, 10, , 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }
}