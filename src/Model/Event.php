<?php


namespace LeanStack\CinetixxAPI\Model;

class Event
{
	/** @var int */
	private $id;

	/** @var string */
	private $title;

	/** @var string */
	private $text;

	/** @var string */
	private $textShort;

	/** @var string */
	private $language;

	/** @var string */
	private $genre;

	/** @var string */
	private $fsk;

	/** @var string */
	private $duration;

	/** @var bool */
	private $format3D;

	/** @var string */
	private $poster;

	/** @var string */
	private $posterBig;

	/** @var string */
	private $trailerLink;

	/** @var string[] */
	private $images;

	/** @var Show[] */
	private $shows;

	/**
	 * Event constructor.
	 */
	public function __construct()
	{
		$this->shows = [];
	}

	/**
	 * @return int
	 */
	public function getId(): int
	{
		return $this->id;
	}

	/**
	 * @param int $id
	 * @return Event
	 */
	public function setId(int $id): Event
	{
		$this->id = $id;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getTitle(): string
	{
		return $this->title;
	}

	/**
	 * @param string $title
	 * @return Event
	 */
	public function setTitle(string $title): Event
	{
		$this->title = $title;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getText(): string
	{
		return $this->text;
	}

	/**
	 * @param string $text
	 * @return Event
	 */
	public function setText(string $text): Event
	{
		$this->text = $text;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getTextShort(): string
	{
		return $this->textShort;
	}

	/**
	 * @param string $textShort
	 * @return Event
	 */
	public function setTextShort(string $textShort): Event
	{
		$this->textShort = $textShort;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getLanguage(): string
	{
		return $this->language;
	}

	/**
	 * @param string $language
	 * @return Event
	 */
	public function setLanguage(string $language): Event
	{
		$this->language = $language;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getGenre(): string
	{
		return $this->genre;
	}

	/**
	 * @param string $genre
	 * @return Event
	 */
	public function setGenre(string $genre): Event
	{
		$this->genre = $genre;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getFsk(): string
	{
		return $this->fsk;
	}

	/**
	 * @param string $fsk
	 * @return Event
	 */
	public function setFsk(string $fsk): Event
	{
		$this->fsk = $fsk;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getDuration(): string
	{
		return $this->duration;
	}

	/**
	 * @param string $duration
	 * @return Event
	 */
	public function setDuration(string $duration): Event
	{
		$this->duration = $duration;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function isFormat3D(): bool
	{
		return $this->format3D;
	}

	/**
	 * @param bool $format3D
	 * @return Event
	 */
	public function setFormat3D(bool $format3D): Event
	{
		$this->format3D = $format3D;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getPoster(): string
	{
		return $this->poster;
	}

	/**
	 * @param string $poster
	 * @return Event
	 */
	public function setPoster(string $poster): Event
	{
		$this->poster = $poster;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getPosterBig(): string
	{
		return $this->posterBig;
	}

	/**
	 * @param string $posterBig
	 * @return Event
	 */
	public function setPosterBig(string $posterBig): Event
	{
		$this->posterBig = $posterBig;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getTrailerLink(): string
	{
		return $this->trailerLink;
	}

	/**
	 * @param string $trailerLink
	 * @return Event
	 */
	public function setTrailerLink(string $trailerLink): Event
	{
		$this->trailerLink = $trailerLink;
		return $this;
	}

	/**
	 * @return string[]
	 */
	public function getImages(): array
	{
		return $this->images;
	}

	/**
	 * @param string $image
	 * @return Event
	 */
	public function addImage(string $image): Event
	{
		// Todo: don't add empty images
		$this->images[] = $image;
		return $this;
	}

	/**
	 * @return Show[]
	 */
	public function getShows(): array
	{
		return $this->shows;
	}

	/**
	 * @param Show $show
	 * @return Event
	 */
	public function addShow(Show $show): Event
	{
		$this->shows[] = $show;
		return $this;
	}
}
