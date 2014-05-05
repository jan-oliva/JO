<?php

namespace JO\Exception;

/**
 * Description of MessageException
 *
 * Message of exception contains message for UI
 *
 * Example:
 * MVC Controller code
 * try{
 *   ....
 * }catch(MessageException $e){
 *	 $this->template->message = $e->getMessage()
 * }
 *
 * @author Jan Oliva
 */
class MessageException extends \Exception
{

}
