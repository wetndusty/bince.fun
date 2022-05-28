<?php
error_reporting(0);
$url = $_GET["url"];
if ($url):
$config = array(
           'indent'         => true,
           'output-xhtml'   => true,
           'wrap'           => 200);

$tidy = new tidy;
$tidy->parseFile($url, $config, 'utf8');
$tidy->cleanRepair();
$clean = (string) $tidy;

$xml = new DOMDocument;
$xml->loadHTML($clean);

$xsl = new DOMDocument;
$xsl->load("proxy.xsl");

$proc = new XSLTProcessor;
$proc->setParameter("", "domain", parse_url($url, PHP_URL_HOST));
$proc->importStyleSheet($xsl);

echo $proc->transformToXML($xml);
//echo $clean;
 else: ?>
<html><head><title>tidy</title><meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css"/></head><body><form method="get" action="tidy.php">
            <input name="url" type="url" placeholder="url" required="required"/>
            <input type="submit"/>
        </form></body></html>
<?php endif;