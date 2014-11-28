<?php
class Transaction 
{	
	protected $referte;
	protected $uitvoeringsdatum;
	protected $valutadatum;
	protected $bedrag;
	protected $munt;
	protected $tegenpartij;
	protected $detail;
	protected $rekening;
	
	public function getDebetCredit() 
	{
		if($this->bedrag < 0) {
			return 'D';
		}
		return 'C'; 
	}
	
	public function getReferteCode() 
	{
		return substr($this->referte, -3);
	}
	
	public function getReferte() 			{ return $this->referte; }
	public function getUitvoeringsdatum()	{ return $this->uitvoeringsdatum; }
	public function getValutadatum()		{ return $this->valutadatum; }
	public function getBedrag()				{ return $this->bedrag; }
	public function getMunt()				{ return $this->munt; }
	public function getTegenpartij() 
	{ 
		return str_replace(' ', '', $this->tegenpartij);
	}
	public function getDetail()				{ return $this->detail;	}
	public function getRekening()			{ return $this->rekening; }
	
	public function setReferte($value)			{ $this->referte = $value; return $this; }
	public function setUitvoeringsdatum($value)	
	{ 
		$this->uitvoeringsdatum = DateTime::createFromFormat('d/m/Y', $value); 
		return $this; 
	}
	public function setValutadatum($value)	
	{ 
		$this->valutadatum = DateTime::createFromFormat('d/m/Y', $value); 
		return $this; 
	}
	public function setBedrag($value) 
	{ 
		$this->bedrag = (float) str_replace(',', '.', $value);
		return $this; 
	}
	public function setMunt($value)				{ $this->munt = $value; return $this; }
	public function setTegenpartij($value)		{ $this->tegenpartij = $value; return $this; }
	public function setDetail($value)			{ $this->detail = $value; return $this; }
	public function setRekening($value)			{ $this->rekening = $value; return $this; }
}
