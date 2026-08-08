<?php

namespace Tests\Unit;

use App\Services\Telegram\TelegramRequestParser;
use InvalidArgumentException;
use Tests\TestCase;

class TelegramRequestParserTest extends TestCase
{
    public function test_can_parse_multiple_requests(): void
    {
        $parser = app(TelegramRequestParser::class);

        $result = $parser->parse(
            <<<'TEXT'
            /req:ketapang
            - dashboard eksekutif | direktur
            - form bank darah | laborat
            - monitoring kasir | keuangan
            TEXT
        );

        $this->assertSame('ketapang', $result['unit_kerja']);

        $this->assertCount(3, $result['requests']);

        $this->assertSame(
            'dashboard eksekutif',
            $result['requests'][0]['judul']
        );

        $this->assertSame(
            'direktur',
            $result['requests'][0]['requester']
        );

        $this->assertNull(
            $result['requests'][0]['priority']
        );
    }

    public function test_can_parse_priority(): void
    {
        $parser = app(TelegramRequestParser::class);

        $result = $parser->parse(
            <<<'TEXT'
            /req:ketapang
            - dashboard eksekutif | direktur | high
            TEXT
        );

        $this->assertSame(
            'high',
            $result['requests'][0]['priority']
        );
    }

    public function test_rejects_invalid_command(): void
    {
        $parser = app(TelegramRequestParser::class);

        $this->expectException(InvalidArgumentException::class);

        $parser->parse(
            '/request:ketapang
            - dashboard | direktur'
        );
    }

    public function test_rejects_empty_content(): void
    {
        $parser = app(TelegramRequestParser::class);

        $this->expectException(InvalidArgumentException::class);

        $parser->parse('/req:ketapang');
    }
}