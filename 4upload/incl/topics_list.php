<? if ($search!=vyhledat) { ?>

<? echo $LNG_TOPICS_LIST; ?>


			<!-- *********************************Vypis diskuzi podle jednotlivych temat****************************** -->
				<?
				//Podle poctu temat vygenerujeme radky
				$topicsResult = _oxResult("SELECT PK_topic, topic_name FROM $TABLE_TOPICS ORDER BY topic_name ASC");

				while($topicsArray = MySQL_Fetch_array($topicsResult)) {
					$topic_number = $topicsArray['PK_topic'];
					$topic_name = $topicsArray['topic_name'];

					//zjisti pocet diskuzi daneho tematu
					$discussionCountArray = _oxQuery("SELECT COUNT(roomid) AS discussions_count FROM $TABLE_ROOMS WHERE FK_topic=$topic_number AND private=0");
					$discussionCount = $discussionCountArray['discussions_count'];

				?>




											<div class="topic">
												<img src="imgs/topic<? echo $topic_number ?>.gif" align="middle">
												<a name="<? echo $topic_number ?>" href="gate.php?m=3&s=1&topic_id=<?echo $topic_number?>#<?echo $topic_number?>">
													<? echo $topic_name; ?>
												</a>
												[<? echo $discussionCount?>]

												[<a href="gate.php?m=3&s=2&topic_id=<?echo $topic_number?>"><? echo $LNG_TOPICS_NEW_DISCUSSION; ?></a>]
										                        
												<!-- pokud je lvl5, zpristupnim editaci //-->
                        <? if ($user_level==5) { ?>
                        [<a href="gate.php?m=3&s=4&topic_id=<?echo $topic_number?>"><? echo $LNG_TOPICS_ADD_SUBCATEGORY; ?></a>]
                        <? } ?>
                        <!-- pokud je lvl5, zpristupnim editaci //-->                                                
											</div>



								<?
								if ($topic_id == $topic_number) {

									//Podle poctu subtemat vygenerujeme radky
									$subtopicsResult = _oxResult("SELECT PK_subtopic, subtopic_name FROM $TABLE_SUBTOPICS WHERE FK_topic=$topic_number");

									while($subtopicsArray = MySQL_Fetch_array($subtopicsResult)) {
										$subtopic_number = $subtopicsArray['PK_subtopic'];
										$subtopic_name = $subtopicsArray['subtopic_name'];;

										//zjisti pocet diskuzi daneho tematu
										$discussionCountArray = _oxQuery("SELECT COUNT(roomid) AS discussions_count FROM $TABLE_ROOMS WHERE FK_topic=$topic_id AND FK_subtopic=$subtopic_number AND private=0");
										$discussionCount = $discussionCountArray['discussions_count'];
								?>
													<div class="subtopic">
														<a name="<? echo $subtopic_number ?>" href="gate.php?m=3&s=1&topic_id=<?echo $topic_id?>&subtopic_id=<?echo $subtopic_number?>#<?echo $subtopic_number?>">
															<? echo $subtopic_name; ?>
														</a>
														[<? echo $discussionCount?>]
                          </div>
                          
												<!-- pokud je lvl5, zpristupnim editaci //-->
                        <? if ($user_level==5) { ?>
                        
                              <div class="edit_subtopic">                                                                                        
                              [<a href="gate.php?m=3&s=2&topic_id=<?echo $topic_number?>&subtopic_id=<?echo $subtopic_number?>"><? echo $LNG_TOPICS_NEW_DISCUSSION; ?></a>]
														
                                                                                                 
                        
                              <br />nebo
                              <form method="post" action="gate.php?m=3&s=1&topic_id=<?echo $topic_id?>&subtopic_id=<?echo $subtopic_number?>#<?echo $subtopic_number?>">
                              
                                    <input type="text" name="subcategory_name" value="<?echo $subtopic_name?>" />
                                    <input type="hidden" name="subcategory_id" value="<?echo $subtopic_number?>" />
                                    <input type="hidden" name="category_id" value="<?echo $topic_id?>" />
                              
                                    <input type="submit" name="change_subcategory_name" value="změnit název subkategorie">
                              </form>
                             
                              <? if ($subtopic_number!=0) { ?>
                                     nebo
                                    <form method="post" action="gate.php?m=3&s=1&topic_id=<?echo $topic_id?>&subtopic_id=<?echo $subtopic_number?>#<?echo $subtopic_number?>">
                                          <input type="hidden" name="subcategory_id" value="<?echo $subtopic_number?>" />
                                          <input type="hidden" name="category_id" value="<?echo $topic_id?>" />
                                          <input type="submit" name="delete_subcategory" value="smazat subkategorii">
                                    </form>
                              <? } ?>
                              </div>
                        <? } ?>
                        <!-- pokud je lvl5, zpristupnim editaci //-->                                                          
													

												<?
												if ($subtopic_id == $subtopic_number) {


													//FUNKCNI, BEZ PODMINKY, ZE JIZ BYL UZIVATEL V DISKUZI
													$result = _oxResult("SELECT $TABLE_ROOMS.founderid, $TABLE_ROOMS.roomid, $TABLE_ROOMS.name, $TABLE_ROOMS.count, $TABLE_ROOMS.home, $TABLE_ROOMS.icon FROM $TABLE_ROOMS WHERE $TABLE_ROOMS.FK_topic=$topic_id AND $TABLE_ROOMS.FK_subtopic=$subtopic_id AND $TABLE_ROOMS.private=0 ORDER BY name ASC");

													while($record=MySQL_Fetch_array($result)) {

														$foundername = getUserLogin($record["founderid"]);

														$roomid = $record["roomid"];
														$room_name = $record["name"];
														$room_count = $record["count"];
														$room_home = $record["home"];
														$room_icon = $record["icon"];
														//$last_access = $record['access_time'];
														//echo $last_access."<br>";





														//TEPRVE ZDE SE PRO KAZDOU DISKUZI ZJISTI, ZDA EXISTUJE ZAZNAM teto diskuze a prihlaseneho uzivatele v ACCESS, pokud ano
														//vyhodime si accesstime, na zaklade ktereho spocitame nove prispevky, pokud ne, nepocitaji se nove prispevky
														//PROMYSLET POUZITI TETO VERZE I V BOOKMARKU !!! - STAVAJICI VERZE ALE ZATIM FUNGUJE OK!!!
														$accessResult = _oxResult("SELECT access_time FROM $TABLE_ROOMS_ACCESS WHERE FK_room=$roomid AND FK_user=$userid");

														if(mysql_num_rows($accessResult)!=0) {
															$accessArray = mysql_fetch_array($accessResult);
															$last_access= $accessArray['access_time'];

															/*zjistim pocet novych prispevku v diskuzi od posledniho cteni diskuze prihlasenym uzivatelem*/
															$res_new_one = _oxResult("SELECT COUNT(fromid) AS fromid FROM $TABLE_ROOM WHERE roomid=$roomid AND date > $last_access AND fromid <> $userid");
															$rec_new_one = mysql_fetch_array($res_new_one);
															$count_new_one = $rec_new_one["fromid"];
															//echo $count_new_one."<br>";
														}else{
															$count_new_one = 0;
														}





														/*zjistim, zda ma dana diskuze anketu*/
														$pool_result=_oxResult("SELECT roomid FROM $TABLE_POOLS WHERE roomid=$roomid");

														if(mysql_num_rows($pool_result)!=0) {
															$pool_record=mysql_fetch_array($pool_result);
															$pool_roomid=$pool_record["roomid"];
														}else{
															$pool_roomid=-1;
														}


														?>

																					<div class="discussion">
																						<?if ($room_icon!="") {?>
																							<a href="gate.php?m=10&s=1&roomid=<? echo $roomid; ?>&newnr=<? echo $count_new_one; ?>">
																								<img src="<?echo $room_icon;?>" width="34" height="24" class="icon2" align="middle">
																							</a>
																						<?}else{?>
																							<img src="imgs/dummy.gif" width="36" height="26" border="0" align="middle">
																						<?}?>

																						<a href="gate.php?m=10&s=1&roomid=<? echo $roomid; ?>&newnr=<? echo $count_new_one; ?>" class="room">
																							<? echo $room_name; ?>
																						</a>
																						(<? echo "$foundername" ?>)
																						[<? echo $room_count; ?>]

																						<? if ($count_new_one != 0) { ?>
																						[<? echo $count_new_one; ?>]
																						<?}?>
																					</div>



																	<? if ($room_home != "" && $pool_roomid != -1) { ?>

																					<div class="discussion">
																						<img src="imgs/dummy.gif" width="170px" height="26px" border="0" align="middle">
																						<? if ($room_home != "") { ?>
																							[<a href="gate.php?m=10&s=3&roomid=<?echo $roomid?>" class="inner_href">homepage</a>]
																						<?}?>
																						<? if ($pool_roomid != -1) { ?>
																							[<a href="discussion.php?m=10&s=2&roomid=<?echo $pool_roomid?>" class="inner_href">anketa</a>]
																						<?}?>
																					</div>

																	<? } ?>


													<?
													}
												}

												?>






									<? } ?>
								<? } ?>






					<? } ?>




<? } ?>

<? if ($search==vyhledat) { ?>

				<?
				if($num_rows == 0) {
				?>
					žádný záznam
				<?
				}else{
				?>
					výsledek vyhledávání
				<?

							while($search_record=MySQL_Fetch_array($search_result)) {

							$foundername = getUserLogin($search_record["founderid"]);
							$topic_id = $search_record["FK_topic"];
							$topic_name = getTopicName($topic_id);
							$room_icon = $search_record["icon"];

							?>

							<?if ($room_icon!="") {?>
								<a href="gate.php?m=10&s=1&roomid=<?echo $bookid;?>&newnr=<? echo $count_new_one; ?>">
								<img src="<?echo $room_icon;?>">
								</a>
							<?}else{?>
							<?}?>
							<a href="gate.php?m=10&s=1&roomid=<? echo $search_record["roomid"]; ?>">
							<? echo $search_record["name"]; ?>
							</a>
							(<? echo $foundername; ?>)|<?echo $topic_name; ?>|[<? echo $search_record["count"]; ?>]
							<?
							}
				}
							?>


<? } ?>
