<?php

namespace App\Model;
use Ramsey\Uuid\Uuid;
class Analiticos {
    private string $id;
    private string $visitor_id;
    private float $x;
    private float $y;
    private string $time;
    private string $isMobile;
    private float $screenWidth;
    private float $screenHeight;

    public function __construct()
    {
        $this->id = Uuid::uuid4()->toString();
    }
    public function getId(): string
    {
        return Uuid::uuid4()->toString();
    }
    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }
    public function getVisitorId(): string
    {
        return $this->visitor_id;
    }
    public function setVisitorId(string $visitor_id): self
    {
        $this->visitor_id = $visitor_id;

        return $this;
    }
    public function getX(): float
    {
        return $this->x;
    }
    public function setX(float $x): self
    {
        $this->x = $x;

        return $this;
    }
    public function getY(): float
    {
        return $this->y;
    }
    public function setY(float $y): self
    {
        $this->y = $y;

        return $this;
    }
    public function getTime(): string
    {
        return $this->time;
    }
    public function setTime(string $time): self
    {
        $this->time = $time;

        return $this;
    }
    public function getIsMobile(): string
    {
        return $this->isMobile;
    }
    public function setIsMobile(string $isMobile): self
    {
        $this->isMobile = $isMobile;

        return $this;
    }
    public function getScreenWidth(): float
    {
        return $this->screenWidth;
    }
    public function setScreenWidth(float $screenWidth): self
    {
        $this->screenWidth = $screenWidth;

        return $this;
    }
    public function getScreenHeight(): float
    {
        return $this->screenHeight;
    }
    public function setScreenHeight(float $screenHeight): self
    {
        $this->screenHeight = $screenHeight;

        return $this;
    }
    }
    