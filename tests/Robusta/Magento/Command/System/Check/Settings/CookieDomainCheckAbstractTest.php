<?php
/*
 * @author Tom Klingenberg <mot@fsfe.org>
 */

namespace Robusta\Magento\Command\System\Check\Settings;

/**
 * Class CookieDomainCheckAbstractTest
 *
 * @covers Robusta\Magento\Command\System\Check\Settings\CookieDomainCheckAbstract
 */
class CookieDomainCheckAbstractTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @see validateCookieDomainAgainstUrl
     */
    public function provideCookieDomainsAndBaseUrls()
    {
        return [
            ["", "", false],
            ["https://www.example.com/", "", false],
            ["", ".example.com", false],
            ["https://www.example.com/", ".example.com", true],
            ["https://www.example.com/", "www.example.com", true],

            ["https://images.example.com/", "www.example.com", false],
            ["https://images.example.com/", "example.com", true],
            ["https://images.example.com/", ".example.com", true],
            ["https://example.com/", ".example.com", false],

            ["https://www.example.com/", ".www.example.com", false],
            ["https://www.example.com/", "wwww.example.com", false],
            ["https://www.example.com/", "ww.example.com", false],
            ["https://www.example.com/", ".ww.example.com", false],
            ["https://www.example.com/", ".w.example.com", false],
            ["https://www.example.com/", "..example.com", false],

            // false-positives we know about, there is no check against public suffix list (the co.uk check)
            ["https://www.example.com/", ".com", false],
            ["https://www.example.co.uk/", ".co.uk", true],
            ["https://www.example.co.uk/", "co.uk", true],

            // go cases <http://gertjans.home.xs4all.nl/javascript/cookies.html>
            ['http://go/', 'go', false],
            ['http://go/', '.go', false],
            ['http://go.go/', 'go', false],
            ['http://go.go/', '.go', false],
            # ... some edge-cases left out
            ['http://www.good.go/', '.good.go', true],
            ['http://www.good.go/', 'www.good.go', true],
            ['http://good.go/', 'www.good.go', false],
            ['http://also.good.go/', 'www.good.go', false],
        ];
    }

    /**
     * @test
     * @dataProvider provideCookieDomainsAndBaseUrls
     */
    public function validateCookieDomainAgainstUrl($baseUrl, $cookieDomain, $expected)
    {
        /** @var CookieDomainCheckAbstract $stub */
        $stub = $this->getMockForAbstractClass(__NAMESPACE__ . '\CookieDomainCheckAbstract', [], '', false);

        $actual = $stub->validateCookieDomainAgainstUrl($cookieDomain, $baseUrl);

        $message = sprintf('%s for %s', $cookieDomain, $baseUrl);

        $this->assertSame($expected, $actual, $message);
    }
}
