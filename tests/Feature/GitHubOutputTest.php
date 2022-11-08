<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class GitHubOutputTest extends TestCase
{
    /** @test */
    public function it_outputs_the_coverage(): void
    {
        $output = $this->runCoverageCheck('/coverage_100.xml');

        $this->assertStringContainsString('"coverage=100" >> $GITHUB_OUTPUT', $output);
    }

    /** @test */
    public function it_outputs_the_display_coverage(): void
    {
        $output = $this->runCoverageCheck('/coverage_100.xml', '50', '0');

        $this->assertStringContainsString('"coverage-display=100%" >> $GITHUB_OUTPUT', $output);
    }

    /** @test */
    public function it_outputs_the_rounded_coverage(): void
    {
        $output = $this->runCoverageCheck('/coverage_1.xml', '50', '2');

        $this->assertStringContainsString('"coverage-rounded=1.46" >> $GITHUB_OUTPUT', $output);
    }

    /** @test */
    public function it_outputs_the_rounded_display_coverage(): void
    {
        $output = $this->runCoverageCheck('/coverage_1.xml', '50', '2');

        $this->assertStringContainsString('"coverage-rounded-display=1.46%" >> $GITHUB_OUTPUT', $output);
    }

    /** @test */
    public function it_outputs_if_the_coverage_is_acceptable(): void
    {
        $output = $this->runCoverageCheck('/coverage_100.xml', '50', '0');

        $this->assertStringContainsString('"coverage-acceptable=true" >> $GITHUB_OUTPUT', $output);
    }

    /** @test */
    public function it_outputs_if_the_coverage_is_unacceptable(): void
    {
        $output = $this->runCoverageCheck('/coverage_1.xml', '50', '0');

        $this->assertStringContainsString('"coverage-acceptable=false" >> $GITHUB_OUTPUT', $output);
    }
}
