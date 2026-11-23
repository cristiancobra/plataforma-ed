<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Concerns\CreatesAuthenticatedUser;
use Tests\TestCase;

class EditLayoutTest extends TestCase
{
    use RefreshDatabase;
    use CreatesAuthenticatedUser;

    public function test_buttons_render_once(): void
    {
        $this->loginAsAccountOwner();
        \Illuminate\Support\Facades\Route::middleware('web')->get('/_probe', fn () => view('_tmp.edit_probe'));
        $html = $this->get('/_probe')->assertOk()->getContent();
        $this->assertSame(1, substr_count($html, 'FTRBTN'));
        $this->assertSame(1, substr_count($html, 'HDRBTN'));
        $html = $this->get('/_probe?att=1')->assertOk()->getContent();
        $this->assertSame(1, substr_count($html, 'FTRBTN'));
        $this->assertGreaterThan(strpos($html, 'ATT'), strpos($html, 'FTRBTN'));
    }
}
