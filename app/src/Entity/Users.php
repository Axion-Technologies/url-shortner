<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UsersRepository::class)
 */
class Users
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="text")
     */
    private $password;

    /**
     * @ORM\Column(type="smallint")
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity=ShortUrls::class, mappedBy="user", orphanRemoval=true)
     */
    private $shortUrls;

    public function __construct()
    {
        $this->shortUrls = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFname(): ?string
    {
        return $this->fname;
    }

    public function setFname(string $fname): self
    {
        $this->fname = $fname;

        return $this;
    }

    public function getLname(): ?string
    {
        return $this->lname;
    }

    public function setLname(string $lname): self
    {
        $this->lname = $lname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, ShortUrls>
     */
    public function getShortUrls(): Collection
    {
        return $this->shortUrls;
    }

    public function addShortUrl(ShortUrls $shortUrl): self
    {
        if (!$this->shortUrls->contains($shortUrl)) {
            $this->shortUrls[] = $shortUrl;
            $shortUrl->setUser($this);
        }

        return $this;
    }

    public function removeShortUrl(ShortUrls $shortUrl): self
    {
        if ($this->shortUrls->removeElement($shortUrl)) {
            // set the owning side to null (unless already changed)
            if ($shortUrl->getUser() === $this) {
                $shortUrl->setUser(null);
            }
        }

        return $this;
    }
}
