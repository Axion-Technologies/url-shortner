<?php

namespace App\Entity;

use App\Repository\ShortUrlsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ShortUrlsRepository::class)
 */
class ShortUrls
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $short_code;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="shortUrls")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getShortCode(): ?string
    {
        return $this->short_code;
    }

    public function setShortCode(string $short_code): self
    {
        $this->short_code = $short_code;

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): self
    {
        $this->user = $user;

        return $this;
    }

    // public function getFullShortUrl(): string
    // {
    //     $short_base_url = $this->getParameter('app.short_url_base');
    //     return $short_base_url .'/' . $this->short_code;
    //     //return 'https://s.gdsk.in/' . $this->short_code;
    // }

}
