<?php
class CsvParser 
{
	public function parse($csv)
	{
		if (($handle = fopen($csv, "r")) !== FALSE) {
		    while (($data = fgetcsv($handle, 0, ';', '"')) !== FALSE) {
		        //$num = count($data);
		        //echo "<p> $num fields in line $row: <br /></p>\n";
		        
		        $transaction = new Transaction();
		        $transaction->setReferte($data[0])
		        			->setUitvoeringsdatum($data[1])
		        			->setValutadatum($data[2])
		        			->setBedrag($data[3])
		        			->setMunt($data[4])
		        			->setTegenpartij($data[5])
		        			->setDetail($data[6])
		        			->setRekening($data[7]);
		        
		        $transactions[] = $transaction;
		        unset($transaction);
		    }
		    array_shift($transactions); // We don't need the first row, as it contains the column headers
		    fclose($handle);
		    
		    return $transactions;
		} else {
			return false;
		}
	}
}