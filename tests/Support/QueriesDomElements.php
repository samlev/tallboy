<?php

namespace Tests\Support;

use DOMDocument;
use DOMNode;
use DOMNodeList;
use DOMXPath;
use Symfony\Component\CssSelector\CssSelectorConverter;

trait QueriesDomElements
{
    protected function getDocument(DOMDocument|string $document): DOMDocument
    {
        return $document instanceof DOMDocument
            ? $document
            : tap(
                new DOMDocument(),
                fn (DOMDocument $dom) => @$dom->loadHTML(
                    mb_convert_encoding($document, 'HTML-ENTITIES', 'UTF-8'),
                    LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
                )
            );
    }

    protected function getNodes(string|DOMDocument $document, string $selector): DOMNodeList
    {
        if (!trim($selector)) {
            return new DOMNodeList();
        }

        return (new DOMXPath($this->getDocument($document)))
            ->query((new CssSelectorConverter())->toXPath($selector));
    }

    protected function getNode(string|DOMDocument $document, string $selector): ?DOMNode
    {
        return $this->getNodes($document, $selector)->item(0);
    }

    /**
     * @return DOMNode[]
     */
    protected function getAncestorNodes(DOMNode $node, bool $onlyElements = false): array
    {
        $ancestors = [];

        $target = $onlyElements ? 'parentNode' : 'parentElement';

        while ($node = $node->$target) {
            $ancestors[] = $node;
        }

        return array_reverse($ancestors);
    }
}
