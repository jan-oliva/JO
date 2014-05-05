<?php

namespace JO\Invoice;

use OndrejBrejla\Eciovni\ParticipantBuilder as PB;

/**
 * Description of ParticipantBuilder
 *
 * @author Jan Oliva
 */
class ParticipantBuilder extends PB
{

	/**
     * Returns new Participant.
     *
     * @return Participant
     */
    public function build()
	{
        return new Participant($this);
    }
}
