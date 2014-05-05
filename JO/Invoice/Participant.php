<?php

namespace JO\Invoice;

use OndrejBrejla\Eciovni\ParticipantImpl;

/**
 * Description of Participant
 *
 * @author Jan Oliva
 */
class Participant extends ParticipantImpl
{
	protected $registrationText;
	
	public function getRegistrationText()
	{
		return $this->registrationText;
	}

	public function setRegistrationText($registrationText)
	{
		$this->registrationText = $registrationText;
		return $this;
	}



}
