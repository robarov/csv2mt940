<?php
class MT940Generator 
{
	public function generate($transactions)
	{
		$saldo = '100000';

		$mt940 = SWIFT . EOL;
	    $mt940 .= '940' . EOL;
	    $mt940 .= SWIFT . EOL;
		$mt940 .= ':20:'  . '940A' . date('ymd') . EOL;    
		
	    $transCount = count($transactions);
	    for($i = 0; $i < $transCount; $i++) {
		    $trans = $transactions[$i];
		    
		    
		    $mt940 .= ':25:'  . $trans->getRekening() . EOL;
		    $mt940 .= ':28C:'  . $trans->getReferte() . EOL;
		    
		    $mt940 .= ':60F:C' . date('ymd') . 'EUR' . $saldo . EOL;
		    $saldo += $trans->getBedrag();
		    
		    
		    $mt940 .= ':61:' . $trans->getValutaDatum()->format('ymd') 
		    				 . $trans->getUitvoeringsDatum()->format('md') 
		    				 . $trans->getDebetCredit() 
		    				 . number_format(abs($trans->getBedrag()), 2, ',', '') 
		    				 . 'NMSCNONREF'
		    				 . '//' . $trans->getTegenpartij() . EOL;
		    				 //. 'NMSC' . $trans->getTegenpartij() . EOL;
		    				 // of dit
		    				 // . 'NMSCNONREF'
		    				 // . '//' . $trans->getTegenpartij() . EOL;
		    				 // of dit
		    				 // . 'NMSC' 
		    				 // . $trans->getReferteCode() 
		    				 // . '//' . $trans->getTegenpartij() . EOL;
	
		    $mt940 .= ':86:' . wordwrap($trans->getDetail(), 65, EOL) . EOL;
		    //$mt940 .= ':86:' . $trans->getDetail() . EOL;
		    
		    $mt940 .= ':62F:' . 'C' . $trans->getUitvoeringsDatum()->format('ymd')  . 'EUR' . number_format(abs($saldo), 2, ',', '') . EOL;
		    unset($trans);
	    }
	    return $mt940;
	}
}