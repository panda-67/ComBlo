<?php

namespace App\Entity;

use App\Repository\ArtikelRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArtikelRepository::class)
 */
class Artikel
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
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $coverFilename;

    /**
     * @ORM\Column(type="datetimetz")
     */
    private $created_on;

    /**
     * @ORM\Column(type="datetimetz")
     */
    private $update_on;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $harga;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $harga_d;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCoverFilename(): string
    {
        return $this->coverFilename;
    }

    public function setCoverFilename(string $coverFilename): self
    {
        $this->coverFilename = $coverFilename;

        return $this;
    }

    public function getCreatedOn(): ?\DateTimeInterface
    {
        return $this->created_on;
    }

    public function setCreatedOn(\DateTimeInterface $created_on): self
    {
        $this->created_on = $created_on;
        // date_create();

        return $this;
    }

    public function getUpdateOn(): ?\DateTimeInterface
    {
        return $this->update_on;
    }

    // public function setUpdated()
    // {
    //     // WILL be saved in the database
    //     $this->updated = new \DateTime("now");
    // }

    public function setUpdateOn(\DateTimeInterface $update_on): self
    {
        // $this->update_on = $update_on;
        $this->update_on = new \DateTime("now");

        return $this;
    }

    public function getHarga(): ?string
    {
        return $this->harga;
    }

    public function setHarga(?string $harga): self
    {
        $this->harga = $harga;

        return $this;
    }

    public function getHargaD(): ?string
    {
        return $this->harga_d;
    }

    public function setHargaD(?string $harga_d): self
    {
        $this->harga_d = $harga_d;

        return $this;
    }
}
