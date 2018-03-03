<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Debug\Exception\FatalThrowableError;

class EmailTemplate extends Model
{
    protected $table = 'emailtemplates';

  

    public static function getRecordWithSlug($slug)
    {
        return EmailTemplate::where('slug', '=', $slug)->first();
    }

    /**
     * Common email function to send emails
     * @param  [type] $template [key of the template]
     * @param  [type] $data     [data to be passed to view]
     * @return [type]           [description]
     */
    public function sendEmail($template, $data)
    {	$template = EmailTemplate::where('title', '=', $template)->first();
    	$content = \Blade::compileString($this->getTemplate($template));
		$result = $this->render($content, $data);
		\Mail::send('emails.template', ['body' => $result], function ($message) use ($template, $data) 
        {
		    $message->from($template->from_email, $template->from_name);
		    $message->to($data['to_email'])->subject($template->subject);
		});
	}

	/**
	 * Returns the template html code by forming header, body and footer
	 * @param  [type] $template [description]
	 * @return [type]           [description]
	 */
	public function getTemplate($template)
	{
		$header = EmailTemplate::where('title', '=', 'header')->first();
    	$footer = EmailTemplate::where('title', '=', 'footer')->first();
    	
    	$view = \View::make('emails.template', [
    											'header' => $header->content, 
    											'footer' => $footer->content,
    											'body'  => $template->content, 
    											]);

		return $view->render();
	}

	/**
	 * Prepares the view from string passed along with data
	 * @param  [type] $__php  [description]
	 * @param  [type] $__data [description]
	 * @return [type]         [description]
	 */
    public function render($__php, $__data)
	{
	    $obLevel = ob_get_level();
	    ob_start();
	    extract($__data, EXTR_SKIP);
	    try {
	        eval('?' . '>' . $__php);
	    } catch (Exception $e) {
	        while (ob_get_level() > $obLevel) ob_end_clean();
	        throw $e;
	    } catch (Throwable $e) {
	        while (ob_get_level() > $obLevel) ob_end_clean();
	        throw new FatalThrowableError($e);
	    }
	    return ob_get_clean();
	}

}
