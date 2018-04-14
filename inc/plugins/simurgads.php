<?php
/*
MyBB 1.8 İlk Mesajda Reklam Gösterme Eklentisi v1.0
Eklenti Yapımcısı: Hüseyin KÖRBALTA (Simurg)
Website: https://huseyinkorbalta.com - https://mybb.com.tr
Güncelleme Tarihi: 14.04.2018
Github: 
*/

// MyBB dışında bu dosyaya erişimi yasakla.
if(!defined("IN_MYBB"))
{
	die("Bu dosyaya erişim yetkiniz bulunmuyor.");
}

//Postbit Şablonuna Reklam Alanı Ekle
$plugins->add_hook("postbit", "simurgads_start");

// Eklenti Bilgileri
function simurgads_info()
{
	global $lang;
	$lang->load('simurgads');
	
	return array(
		"name"			=> $lang->simurgads_adi,
		"description"	=> $lang->simurgads_aciklama,
		"website"		=> $lang->simurgads_web,
		"author"		=> $lang->simurgads_yapimci,
		"authorsite"	=> $lang->simurgads_yapweb,
		"version"		=> "1.0",
		"compatibility" => "18*"
	);
}

// Eklenti Aktif Olunca
function simurgads_activate()
{
	global $db,$lang;
	$lang->load('simurgads');
	$simurgads_group = array(
		"gid" => "NULL",
		"name" => "simurgads",
		"title" =>  $lang->simurgads_eklentiayarlari,
		"description" => $lang->simurgads_aciklamasi,
		"disporder" => "15",
		"isdefault" => "no",
	);
	$db->insert_query("settinggroups", $simurgads_group);
	$gid = $db->insert_id();
	$simurgads_ayar_1 = array(
		"sid"			=> "NULL",
		"name"			=> "simurgads1",
		"title"			=> $lang->simurgads_aktif,
		"description"	=> $lang->simurgads_aktif_aciklama,
		"optionscode"	=> "onoff",
		"value"			=> '0',
		"disporder"		=> '1',
		"gid"			=> intval($gid),
	);
	$simurgads_ayar_2 = array(
		"sid"			=> "NULL",
		"name"			=> "simurgads2",
		"title"			=> $lang->simurgads_adskonum,
		"description"	=> $lang->simurgads_adskonum_aciklama,
		"optionscode"	=> "radio
			1 = Sağ Tarafta Göster
			2 = Sol Tarafta Göster
			3 = Üst Tarafta Göster
			4 = Alt Tarafta Göster",
		"value"			=> '1',
		"disporder"		=> '3',
		"gid"			=> intval($gid),
	);
	$simurgads_ayar_3 = array(
		"sid"			=> "NULL",
		"name"			=> "simurgads3",
		"title"			=> $lang->simurgads_reklamkodu,
		"description"	=> $lang->simurgads_reklamkodu_aciklama,
		"optionscode"	=> "textarea",
		"value"			=> 'Reklam Kodunu Buraya Ekleyiniz...<br /><a href="https://huseyinkorbalta.com" target="_blank">Hüseyin Körbalta - Kişisel Blog</a>',
		"disporder"		=> '4',
		"gid"			=> intval($gid),
	);
		$simurgads_ayar_4 = array(
		"sid"			=> "NULL",
		"name"			=> "simurgads4",
		"title"			=> $lang->simurgads_ikincireklamkodu,
		"description"	=> $lang->simurgads_ikincireklamkodu_aciklama,
		"optionscode"	=> "textarea",
		"value"			=> 'Reklam Kodunu Buraya Ekleyiniz...<br /><a href="https://huseyinkorbalta.com" target="_blank">Hüseyin Körbalta - Kişisel Blog</a>',
		"disporder"		=> '5',
		"gid"			=> intval($gid),
	);
	$simurgads_ayar_5 = array(
		"sid"			=> "NULL",
		"name"			=> "simurgads5",
		"title"			=> $lang->simurgads_reklamgösterimi,
		"description"	=> $lang->simurgads_reklamgösterimi_aciklama,
		"optionscode"	=> "yesno",
		"value"			=> '1',
		"disporder"		=> '2',
		"gid"			=> intval($gid),
	);
	$simurgads_ayar_6 = array(
		"sid"			=> "NULL",
		"name"			=> "simurgads6",
		"title"			=> $lang->simurgads_forumizinleri,
		"description"	=> $lang->simurgads_forumizinleri_aciklama,
		"optionscode"	=> "text",
		"value"			=> '',
		"disporder"		=> '6',
		"gid"			=> intval($gid),
	);
	$simurgads_ayar_7 = array(
		"sid"			=> "NULL",
		"name"			=> "simurgads7",
		"title"			=> $lang->simurgads_kullanicizinleri,
		"description"	=> $lang->simurgads_kullanicizinleri_aciklama,
		"optionscode"	=> "text",
		"value"			=> '',
		"disporder"		=> '7',
		"gid"			=> intval($gid),
	);
	
	// Eklenti Ayarlarını Veritabanına Ekle
	$db->insert_query("settings", $simurgads_ayar_1);
	$db->insert_query("settings", $simurgads_ayar_2);
	$db->insert_query("settings", $simurgads_ayar_3);
	$db->insert_query("settings", $simurgads_ayar_4);
	$db->insert_query("settings", $simurgads_ayar_5);
	$db->insert_query("settings", $simurgads_ayar_6);
	$db->insert_query("settings", $simurgads_ayar_7);
}
// Eklenti Kapatıldığında / Aktif Olmadığında
function simurgads_deactivate()
{
	global $db;
	$db->query("DELETE FROM ".TABLE_PREFIX."settinggroups WHERE name='simurgads'");
	$db->query("DELETE FROM ".TABLE_PREFIX."settings WHERE name='simurgads1'");
	$db->query("DELETE FROM ".TABLE_PREFIX."settings WHERE name='simurgads2'");
	$db->query("DELETE FROM ".TABLE_PREFIX."settings WHERE name='simurgads3'");
	$db->query("DELETE FROM ".TABLE_PREFIX."settings WHERE name='simurgads4'");
	$db->query("DELETE FROM ".TABLE_PREFIX."settings WHERE name='simurgads5'");
	$db->query("DELETE FROM ".TABLE_PREFIX."settings WHERE name='simurgads6'");
	$db->query("DELETE FROM ".TABLE_PREFIX."settings WHERE name='simurgads7'");
}
// Eklenti Aktif Olduğunda Tema Şablonlarında Yapılacak İşlemler
function simurgads_start(&$post)
{
	global $postcounter,$mybb;
	// Eklenti Aktif/Kapalı
	If ($mybb->settings['simurgads1'] == 1)
	{
		// Reklamlar kaç mesaj sonra gösterilecek 
		if ($mybb->settings['simurgads5'] == 1)
			{
				$lol1 = $postcounter - 1;
				$lol2 = $mybb->settings['postsperpage'];
			}
			Else
			{
				$lol1 = 1;
				$lol2 = 2;
			}
		if ($postcounter == "1" || ($lol1 % $lol2 == "0"))
		{
			$display = true;
			// Reklamların gösterilmeyeceği forumlar
			$rofl1 = explode(",",$mybb->settings['simurgads6']);
			foreach($rofl1 as $rofl2)
			{
				if (trim($rofl2) == $post['fid'])
				{
				$display = false;
				}
				// Reklamların gösterilmeyeceği üye grupları
				Else
				{
					$rofl3 = explode(",",$mybb->settings['simurgads7']);
					foreach($rofl3 as $rofl4)
						{
							if (trim($rofl4) == $mybb->user['usergroup'])
							{
							$display = false;
							}
						}
				}
			}
		}
		if ($display)
		{
			{
				// Reklam Kodları
				$simurgreklam= $mybb->settings['simurgads3'];
				$simurgreklam2= $mybb->settings['simurgads4'];
				// Reklam kodlarını forumda göster
				If ($mybb->settings['simurgads2'] == 1)
				{
					$post['message'] = "<div style=\"float:right;\">{$simurgreklam}</div>{$post['message']}<div style=\"clear:both;\">";
				}
				Elseif ($mybb->settings['simurgads2'] == 2)
				{
					$post['message'] = "<div style=\"float:left;\">{$simurgreklam}</div>{$post['message']}<div style=\"clear:both;\">";
				}
				Elseif ($mybb->settings['simurgads2'] == 3)
				{
					$post['message'] = "{$simurgreklam}<br />{$post['message']}";
					$post['message'] = "{$post['message']}<br />{$simurgreklam2}";
				}
				Elseif ($mybb->settings['simurgads2'] == 4)
				{
					$post['message'] = "{$post['message']}<br />{$simurgreklam}";
				}
				// Rekla kodlarının forumda gösterimi bitti
			}
		}
	}
}

?>
