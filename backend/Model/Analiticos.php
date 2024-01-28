<?php

namespace App\Model;

class Analiticos {
    private int $id;
    private string $visitor_id;
    private int $x;
    private int $y;
    private string $time;
    private string $isMobile;
    private int $screenWidth;
    private int $screenHeight;

    public function __construct()
    {
       
    }
    public function getId(): int
    {
        return $this->id;
    }
    public function setId(int $id): self
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
    public function getX(): int
    {
        return $this->x;
    }
    public function setX(int $x): self
    {
        $this->x = $x;

        return $this;
    }
    public function getY(): int
    {
        return $this->y;
    }
    public function setY(int $y): self
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
    public function getScreenWidth(): int
    {
        return $this->screenWidth;
    }
    public function setScreenWidth(int $screenWidth): self
    {
        $this->screenWidth = $screenWidth;

        return $this;
    }
    public function getScreenHeight(): int
    {
        return $this->screenHeight;
    }
    public function setScreenHeight(int $screenHeight): self
    {
        $this->screenHeight = $screenHeight;

        return $this;
    }
    }
    