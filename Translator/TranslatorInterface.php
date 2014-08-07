<?php

namespace Avro\TranslatorBundle\Translator;

/**
 * @author Joris de Wit <joris.w.dewit@gmail.com>
 */
interface TranslatorInterface
{
    public function translate($string, $from, $to);
}
