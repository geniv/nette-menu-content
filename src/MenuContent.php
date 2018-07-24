<?php declare(strict_types=1);

use Dibi\Connection;
use Dibi\Fluent;
use GeneralForm\ITemplatePath;
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
class MenuContent extends Control implements ITemplatePath
{
    // define constant table names
    const
        TABLE_NAME_MENU = 'menu',
        TABLE_NAME_MENU_CONTENT = 'menu_content';

    /** @var string */
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
    /** @var array */
    private $templatePathByIdent = [];


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
        $this->tableContent = $prefix . self::TABLE_NAME_MENU_CONTENT;

        $this->connection = $connection;
        $this->idLocale = $locale->getId();
        $this->translator = $translator;
        $this->cache = new Cache($storage, 'cache-MenuContent');

        $this->templatePath = __DIR__ . '/MenuContent.latte';  // set path
    }


    /**
     * Set template path.
     *
     * @param string $path
     */
    public function setTemplatePath(string $path)
    {
        $this->templatePath = $path;
    }


    /**
     * Set template path by ident.
     *
     * @param string $identification
     * @param string $path
     */
    public function setTemplatePathByIdent(string $identification, string $path)
    {
        $this->templatePathByIdent[$identification] = $path;
    }


    /**
     * Set id locale.
     *
     * @param $idLocale
     */
    public function setIdLocale($idLocale)
    {
        $this->idLocale = $idLocale;
    }


    /**
     * Get list menu.
     *
     * @param string $identification
     * @param string $select
     * @return Fluent
     */
    private function getListMenu(string $identification = '', $select = 'id, name'): Fluent
    {
        $result = $this->connection->select($select)
            ->from($this->tableMenu)
            ->orderBy(['position' => 'asc']);
//TODO optimalize query
        if ($this->idLocale) {
            $result->where(['id_locale' => $this->idLocale]);
        }

        if ($identification) {
            $result->where(['ident' => $identification]);
        }
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
     * Render.
     *
     * @param string $identification
     */
    public function render(string $identification = '')
    {
        $template = $this->getTemplate();

        if (!$this->idMenu) {
            // select fist item and switch menu + fallback null data
            $this->handleSelectMenu($this->getListMenu($identification, 'id')->fetchSingle() ?: 0);
        }

        $this->template->idMenu = $this->idMenu;
        $this->template->listMenu = $this->getListMenu($identification);
        $this->template->listContent = $this->getListContent($this->idMenu);

        $template->setTranslator($this->translator);
        if ($identification && isset($this->templatePathByIdent[$identification])) {
            $template->setFile($this->templatePathByIdent[$identification]);
        } else {
            $template->setFile($this->templatePath);
        }
        $template->render();
    }
}
