<? /* SUBMENU */ ?>
<? //include('incl/sub_menu.php'); ?>
<? /* SUBMENU */ ?>

<div>
		<div class="help_header">ÚVOD</div>
		<div class="help_content">
    DS je diskuzní a komunikační systém, který je provozován pro účely prezentace na adrese ds.zavrel.net.
		DS je typickým příkladem webové aplikace, tedy programu, který vyžaduje pro svůj provoz jednak prohlížeč webu
    (client-side) a na druhé straně skriptovací jazyk a datové úložiště (server-side).
		Celá tato webová aplikace je založena na dvou elementárních úkonech. Prvním z nich je dotaz, druhým je odpověď na tento
    dotaz.
		Dotaz pokládá uživatel prostřednictvím svého webového prohlížeče, který tento dotaz zašle serveru. Server dotaz zpracuje
    a zašle zpět prohlížeči odpověď a ten jí zobrazí uživateli.
    </div>
	

		<div class="help_header">TECHNOLOGIE</div>
		<div class="help_content">
    DS je kombinací tří základních technologií.
		Na straně webového prohlížeče se jedná o HTML (HyperText Markup Language) doplněnou Javascriptem.
		Na straně serveru se jedná o PHP (skriptovací jazyk) a MySQL (relační databáze).
	  </div> 

	
		<div class="help_header">POUŽITÍ</div>
		<div class="help_content">
    DS je systémem výměny informací.
		DS uchovává na centrálním úložišti dostupném z Internetu informace vložené jedním uživatelem systému
		a tyto informace poskytuje na požádání jinému uživateli systému, čímž zprostředkovává mezi těmito uživateli
		komunikaci v elektronické, konkrétně pak písemné formě.
    </div>	

	
		<div class="help_header">POŽADAVKY</div>
		<div class="help_content">
    Požadavky systému se odvíjejí od jeho použití. Pro běh systému je vyžadován server připojený do sítě Internet,
		který je schopen interpretovat kód PHP skriptovacího jazyka a poskytovat webové stránky webovému prohlížeči a dále
		obsahuje datové úložiště pro sběr a uchovávání informací poskytovaných uživateli systému.
		Konkrétně se jedná o výše zmíněné technologie PHP a MySQL, které jsou volně dostupné k nekomerčnímu použití.
		Poskytování webových stránek na požádání pak zajišťuje tzv. webserver, např. Apache Web Server.
	  </div> 

	
		<div class="help_header">UŽIVATELÉ</div>
		<div class="help_content">
    Počet uživatelů systému není přímo nijak omezen a nepřímo se toto omezení týká pouze snižování výkonu systému
		ve smyslu zvýšené reakční doby v případě velkého množství uživatelů, stejně jako zvýšených nároků na kapacitu
		datového úložiště.
		Klíčovým prvkem pro efektivní fungování systému je identifikace uživatele. Na základě této identifikace
		nabízí systém konkrétnímu uživateli konkrétní služby, které by byly v případě anonymního pobytu v systému
		velmi omezeny.
		Identifikace uživatele je zajištěna nutností přihlášení se do systému před možností se systémem pracovat.
		Uživatel se identifikuje prostřednictvím unikátního uživatelského jména, jehož používání vyplývá z oprávnění,
		kterým je uživatelské heslo.
		Při registraci uživatele, která předchází prvotnímu přístupu do systému, si systém vyžádá od uživatele oba tyto
		identifikační údaje a po celou dobu existence uživatelského účtu je vede v datovém úložišti. Přihlášení uživatele
		do systému je pak proces, ve kterém se ověřuje shoda údajů zadaných uživatelem při vstupu do systému s údaji,
		které uživatel uložil do systému při registraci. Předpokládá se, že právě ten uživatel, který údaje při registraci
		vložil je tím uživatelem, který je při opakovaném přístupu do systému zadává. Systém nemá žádné jiné ověřovací
		postupy ani prostředky, kterými by vyloučil zcizení a zneužití těchto uživatelem poskytnutých přihlašovacích
		údajů. Z tohoto důvodu je nutné, aby uživatel vedl tyto údaje jako choulostivé a zejména neumožnil přístup třetích osob
		k těmto údajům. Jakmile jsou údaje správně zadány, systém umožní uživateli práci v systému až se jedná o skutečného
		uživatele, nebo třetí osobu, která údaje získala.
	  </div> 

	
		<div class="help_header">HESLA</div>
		<div class="help_content">
    Jelikož je heslo jediným skutečně privátním údajem, který zprostředkovává uživateli přístup do systému, je tento údaj
		pouze v rukách uživatele. Systém uživatelské heslo nezná, čímž je zajištěna bezpečnost uživatele ve smyslu nemožnosti
    zjištění hesla ze systému. Jediný subjekt od kterého je heslo získatelné je uživatel sám. Při registraci uživatele
		je heslo před uložením do datového úložiště zakódováno algoritmem bez možnosti dekódování. Při případném pokusu o získání
		přístupu do systému by tak útočník získal pouze zakódované heslo, které nemá možnost dekódovat a tudíž není možno jej
    použít pro vstup do systému. Jediný, kdo zná přístupové heslo v nezakódované podobě je uživatel sám. Z toho plyne nutnost heslo
		pečlivě a bezpečně uchovat, neboť případné zapomenuté heslo nelze ze systému nijak získat a je třeba vytvořit heslo
    zcela nové, čemuž však musí předcházet dodatečná identifikace oprávněného uživatele, aby nebyl tento postup možným způsobem zneužití přístupu
		do systému.
	  </div> 

	
		<div class="help_header">EDITORY</div>
		<div class="help_content">
    V rámci celého systému má uživatel možnost vkládat na několika místech textové informace, které jsou
		po odeslání uloženy v databázi a uchovány tak pro pozdější použití, mezi což patří jednak čtení těchto informací,
		dále pak také jejich editace a konečně odstraňování.
		Mezi základní typy textových informací patří zprávy v rámci modulu pošta a příspěvky v rámci modulu diskuze.
		Mezi doplňkové typy textových informací patří v rámci modulu diskuze tvorba, editace a mazání homepage, tvorba, editace
    a mazání minihomepage a v rámci modulu nastavení tvorba, editace a mazání osobní stránky.<br />
		Vkládání textu je umožněno uživateli třemi způsoby:
		<ol>
		<li>
    Nejsofistikovanější způsob je prostřednictvím editoru WYSIWYG, který umožňuje velmi pohodlné vkládání celých
		html struktur jako jsou tabulky, odstavce, číslované seznamy, obrázky, odkazy, atp. Tento způsob však vyžaduje jednak
		zapnutý Javascript a vzhledem k tomu, že např. tvorba tabulek je možná pouze pomocí myši, bude nejspíš použit pouze
		při práci v systému na stolním počítači.
		</li>
    <li>
    Druhým způsobem je vkládání čistého textu. Tento způsob je zlatou střední cestou pro ty, kteří nepotřebují vytvářet
		složité html struktury, ale namísto toho chtějí rychle reagovat např. v nějaké diskuzi. Zde je opět vyžadován Javascript,
		ovšem pouze k pohodlnému doplnění určitých kódů pro zobrazení odkazu, obrázku, podtržení textu, atp. Hodí se jak na PC, tak
		na mobilních zařízeních podporujících javascriptové minimum.
		</li>
    <li>
    Třetím a nejméně přívětivým způsobem je vkládání čistého textu, bez jakékoliv výpomoci a tudíž je zde třeba ručně vložit
		i veškeré kódy nutné k vygenerování odkazů, atp. Na druhé straně lze tento způsob použít téměř na všech zařízeních.<br />
	  Seznam použitelných kódů:
	   <ol>
					<li>[url][/url] pro vložení odkazu</li>
					<li>[img][/img] pro vloľení obrázku</li>
					<li>[u][/u] pro vložení podtrženého textu</li>
     </ol> 					
		</li>
    </ol>
    </div> 

	
		<div class="help_header">PŘÍSPĚVKY</div>
		<div class="help_content">
    Příspěvky jsou zprávy v diskuzích. Každý příspěvek má mimo jiné svoje unikátní číslo, čili identifikátor, který
		naleznete v hlaviččce příspěvku úplně nakonci a poznáte ho tak, že se před ním nachází znak #. Tedy například pokud
		se v diskuzi Novinky v systému nachází příspěvek s #2367 znamená to, že od začátku existence systému byl toto dvoutisící
		třístý šedesátý sedmý napsaný příspěvek. Některé systémy vedou číslování příspěvků pro každou diskuzi zvlášť, což může být
		ovšem matoucí v případě potřeby konkrétní příspěvek zcela přesně identifikovat. V systému DS má každý příspěvek svoje vlastní
		unikátní číslo bez ohledu na to, ve které diskuzi se nachází. Příspěvky si ponechávají svoje číslo i pokud dojde k jejich vymazání.
		Jinými slovy nehrozí, že pokud bude vymazán příspěvek číslo #157 a v zápětí napsán příspěvek nový, že by tento nový příspěvek
    obdržel stejné číslo, nový příspěvek obdrží číslo #158. Toto chování systému zajišťuje uživateli možnost kdykoliv se odkázat na konkrétní
		příspěvek prostřednictvím jeho čísla. Pokud by byl příspěvek smazán, bude odkaz neplatný, což je ovšem daleko bezpečnější, než
    kdyby odkazoval na úplně jiný příspěvek se stejným číslem.
	  </div> 

	
		<div class="help_header">AT A LEVELY</div>
		<div class="help_content">
    Je účelné sledovat délku pobytu uživatele v systému, díky čemuž lze následně uživatele ohodnotit, případně mu svěřit některé funkce
		související se správou systému, což je vhodné zejména v případě velkého množství uživatelů a diskuzí. Ke sledování uživatele v
    systému existuje systém AT bodů a systém LEVELů. AT čili Action Tokens jsou body, které uživateli narůstají na základě jeho skutečného
    pohybu v systému. Aby nedocházelo ke zneužití tohoto systému různými autorefreshi atp., existuje minimální prodleva, kterou je třeba splnit,
    aby systém započítal uživateli další AT. AT jsou následně prostřednictvím LEVELů spojeny s určitými výhodami, mezi které patří například
		webový prostor v rámci systému atp.
		LEVELY vycházejí částečně z AT, kdy po dosažení určitého počtu AT získává uživatel vyšší level, který mu zajišťuje výše
    zmíněné výhody. Systém pracuje aktuálně s šesti levelovými stupni, přičemž nejnižším stupněm je 0 a nejvyšším stupněm 5. Každý uživatel systému
    začíná s levelem 0 a tento level lze postupně prostřednictvím AT navýšit až na level 3, což je maximální level dosažitelný čistě
    prostřednictvím AT. Levely 4 a 5 se již od AT neodvíjí. Level 4 může získat uživatel na základě rozhodnutí uživatelů s levelem 5. Level 5 je
    vyhrazen správcům systému a stát se správcem vyžaduje jednak výjimečnou znalost systému, spolehlivost a pravidelný přístup do systému,
    jelikož je spojen s určitými povinnostmi. Level 5 může uživateli udělit pouze majitel serveru/hlavní administrátor. Uživatelé s levelem 5
    zejména usnadňují práci hlavnímu administrátorovi systému tím, že řadí diskuze do příslušných tématických kategorií, provádějí údržbu
    diskuzí v případě, že diskuze nedodržují pravidla systému a pomáhájí nováčkům s pochopením systému.
	  </div> 

	
		<div class="help_header">ZAHESLOVANÉ DISKUZE</div>
		<div class="help_content">
    V případě, že potřebuje uživatel vytvořit diskuzi pro omezený počet lidí (může se jednat například o diskuzi určité skupiny)
		existuje možnost tuto diskuzi zaheslovat a sdělit heslo pouze těm, kteří mají mít do této diskuze přístup.
		Zaheslovaná diskuze není automaticky diskuzí privátní, tj. diskuze se zobrazuje v TÉMATECH.
		Po vložení správného hesla se uživatel dostane do diskuze a může v rámci této diskuze využívat
		všech funkcí do té doby, než navštíví diskuzi jinou, poté musí opět zadat heslo.
		Zcela záměrně neexistuje možnost pamatovat si uživatele, který jednou heslo zadal a znovu
		po něm heslo nevyžadovat, neboť toto by v případě zneužití uživatelského účtu vedlo i k automatickému
		přístupu do všech diskuzí, k nimž měl uživatel přístup.
	  </div> 
		
	
</div>



