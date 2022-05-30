<?php

namespace App\Channels\Messages;

class WhatsAppMessage
{
  public $content;
  public $number;

  public function content($content)
  {
    $this->content = $content;

    return $this;
  }
  
  public function number($number)
  {
    $this->number = $number;

    return $this;
  }
}