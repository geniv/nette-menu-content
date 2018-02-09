<?php declare(strict_types=1);

use Dibi\Connection;
use Dibi\Fluent;
use Locale\ILocale;
use Nette\Application\UI\Control;
use Nette\Caching\Cache;
use Nette\Caching\IStorage;
use Nette\Localization\ITranslator;


/**
 * Class MenuContent
 *
 * @author  geniv
 */
class MenuContent extends Control
{
    // define constant table names
    const
        TABLE_NAME_MENU = 'menu',
        TABLE_NAME_CONTENT = 'content';

    /** @var string tables name */
    private $tableMenu, $tableContent;
    /** @var Connection */
    private $connection;
    /** @var int */
    private $idLocale;
    /** @var ITranslator|null */
    private $translator;
    /** @var Cache caching */
    private $cache;
    /** @var string */
    private $templatePath;
    /** @var int */
    private $idMenu = 0;


    /**
     * MenuContent constructor.
     *
     * @param                  $prefix
     * @param Connection       $connection
     * @param ILocale          $locale
     * @param ITranslator|null $translator
     * @param IStorage         $storage
     */
    public function __construct($prefix, Connection $connection, ILocale $locale, ITranslator $translator = null, IStorage $storage)
    {
        parent::__construct();

        // define table names
        $this->tableMenu = $prefix . self::TABLE_NAME_MENU;
        $this->tableContent = $prefix . self::TABLE_NAME_CONTENT;

        $this->connection = $connection;
        $this->idLocale = $locale->getId();
        $this->translator = $translator;
        $this->cache = new Cache($storage, 'cache-MenuContent');

        $this->templatePath = __DIR__ . '/MenuContent.latte';  // set path
    }


    /**
     * Set template path.
     *
     * @param string $templatePath
     * @return $this
     */
    public function setTemplatePath(string $templatePath): self
    {
        $this->templatePath = $templatePath;
        return $this;
    }


    /**
     * Get list menu.
     *
     * @return Fluent
     */
    private function getListMenu(): Fluent
    {
        $result = $this->connection->select('id, name')
            ->from($this->tableMenu)
            ->orderBy(['position' => 'asc']);

        if ($this->idLocale) {
            //dump($this->idLocale);    //TODO doresit jazyky!
        }
        return $result;
    }


    /**
     * Get first id.
     *
     * @return int
     */
    private function getFirstId(): int
    {
        return $this->connection->select('id')
            ->from($this->tableMenu)
            ->orderBy(['position' => 'asc'])
            ->fetchSingle();
    }


    /**
     * Get list content.
     *
     * @param $idMenu
     * @return Fluent
     */
    private function getListContent(int $idMenu): Fluent
    {
        $result = $this->connection->select('id, content, added, updated')
            ->from($this->tableContent)
            ->where(['id_rule_menu' => $idMenu, 'active' => true, 'deleted' => null])
            ->orderBy(['position' => 'asc']);
        return $result;
    }


    /**
     * Handle select menu.
     *
     * @param int $id
     */
    public function handleSelectMenu(int $id)
    {
        $this->idMenu = $id;

        if ($this->presenter->isAjax()) {
            $this->redrawControl('content');
        }
    }


    /**
     * Render.
     */
    public function render()
    {
        $template = $this->getTemplate();

        if (!$this->idMenu) {
            $this->handleSelectMenu($this->getFirstId());
        }

        $this->template->idMenu = $this->idMenu;
        $this->template->listMenu = $this->getListMenu();
        $this->template->listContent = $this->getListContent($this->idMenu);

        $template->setTranslator($this->translator);
        $template->setFile($this->templatePath);
        $template->render();
    }
}
