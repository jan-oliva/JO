<?php

namespace JO\Invoice;

//use OndrejBrejla\Eciovni\Eciovni;



/**
 * Description of InvoiceView
 *
 * @author Jan Oliva
 */
class InvoiceViewVatLess extends Eciovni
{
	function __construct(\OndrejBrejla\Eciovni\Data $data = NULL)
	{
		parent::__construct($data);

		//$this->setTemplatePath(__DIR__ . '/templates/Eciovni.latte');
		$this->setTemplatePath(__DIR__ . '/templates/VatLess.latte');
	}

}
