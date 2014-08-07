Avro Translator Bundle
-------------------------

A Symfony2 bundle that utilizes Microsoft Translator to translate text.
Unlike Google translate, Microsoft translate has a free plan that allows for 2 000 000 characters to be translated per month.

See <a href="http://blogs.msdn.com/b/translation/p/gettingstarted1.aspx">Microsoft Translator Docs</a> on how to setup your azure account to get your clientID and client secret. 

###Install

```
$ composer install avro/translator-bundle
```

Add bundle to AppKernel.
```php
    new Avro\TranslatorBundle\AvroTranslatorBundle(),
```

###Config
```
avro_translator:
    azure:
        client_id: %azure_client_id%
        client_secret: %azure_client_secret%
```    

###Usage

Translator is available as a service

```php
// translate some text from english to spanish
$newText = $this->container->get('avro_translator.translator')->translate('Some text here', 'en', 'es');
```

###License
MIT
