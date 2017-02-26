<strong>statistiky uživatele <? echo "$user_info_login"; ?></strong> <br />

				<?
					if ($user_info_viewers != "" && $user_info_viewers != ",") {
						?>seznam uživatelů, kteří viděli informace o uživateli <? echo "$user_info_login" ?><?

							$x=0;
							//pouzivam pocet polozek pole z parsrovanych keeperu, protoze pokud nekterou polozku
							//parser vynecha, uz neni zapocitavana a to je spatne, proste to nech takhle !!!
							for ($i=0; $i<=$user_info_viewers_num-1; $i++) {
								if ($user_info_viewers_id[$i] != "") {
									$x++;
									?>
									<div>
									<a href="gate.php?m=11&s=1&fuserid=<? echo $user_info_viewers_id[$i] ?>">
										<img src="ico/<? echo getUserLogin($user_info_viewers_id[$i]) ?>.gif" alt="<? echo getUserLogin($user_info_viewers_id[$i]) ?>" title="<? echo getUserLogin($user_info_viewers_id[$i]) ?>" />
									</a>
									<? echo getUserLogin($user_info_viewers_id[$i]) ?>
									<?
									if ($x >=1) { echo "</div><div>"; $x=0;}
								}

							}

					}
				?>

