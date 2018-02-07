<section class="section-content-search mt150">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="nav-search">
                    <?php echo form_open('user/browsing', array('id' => 'frm_browsing')); ?>
                    <h3 class="mt0">Søgning</h3>
                    <div class="form-group">
                        <label for="">Alder</label>
                        <div class="row">
                            <div class="col-sm-6 col-md-6 col-xs-6">
                                <select name="year_from" class="form-control">
                                    <?php for ($i = 18; $i < 100; $i++) { ?>
                                        <option <?php if ($year_from == $i) {
                                            echo 'selected="true"';
                                        } ?> value="<?php echo $i; ?>"><?php echo $i; ?> år
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-sm-6 col-md-6 col-xs-6">
                                <select name="year_to" class="form-control">
                                    <?php
                                    $year_to = $year_to < 100 ? $year_to : 99;
                                    for ($i = 19; $i < 100; $i++) {
                                        ?>
                                        <option <?php if ($year_to == $i) {
                                            echo 'selected="true"';
                                        } ?> value="<?php echo $i; ?>"><?php echo $i; ?> år
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Højde</label>
                        <div class="row">
                            <div class="col-sm-6 col-md-6 col-xs-6">
                                <select name="height_from" class="form-control">
                                    <?php for ($i = 100; $i < 231; $i++) { ?>
                                        <option <?php if ($height_from == $i) {
                                            echo 'selected="true"';
                                        } ?> value="<?php echo $i; ?>"><?php echo $i; ?> cm
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <?php $height_to = $height_to ? $height_to : 230; ?>
                            <div class="col-sm-6 col-md-6 col-xs-6">
                                <select name="height_to" class="form-control">
                                    <?php for ($i = 100; $i < 231; $i++) { ?>
                                        <option <?php if ($height_to == $i) {
                                            echo 'selected="true';
                                        } ?> value="<?php echo $i; ?>"><?php echo $i; ?> cm
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Køn</label>
                        <select name="gender" class="form-control">
                            <option value="0">Vælg køn</option>
                            <option <?php if ($gender == 1) {
                                echo 'selected="true"';
                            } ?> value="1">Kvinde
                            </option>
                            <option <?php if ($gender == 2) {
                                echo 'selected="true"';
                            } ?> value="2">Mand
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Forhold</label>
                        <div id="list6" class="dropdown-check-list" tabindex="100">
                            <span class="anchor">Alle</span>
                            <ul id="items6" class="items">
                                <li>
                                    <div class="checkbox">
                                        <label><input <?php if ($relationship) {
                                                for ($i = 0; $i < count($relationship); $i++) {
                                                    if ($relationship[$i] == 'Aldrig gift') {
                                                        echo 'checked="true"';
                                                    }
                                                }
                                            } ?> name="relationship[]" value="Aldrig gift" type="checkbox"/> Aldrig gift
                                        </label></div>
                                </li>
                                <li>
                                    <div class="checkbox">
                                        <label><input <?php if ($relationship) {
                                                for ($i = 0; $i < count($relationship); $i++) {
                                                    if ($relationship[$i] == 'Separeret') {
                                                        echo 'checked="true"';
                                                    }
                                                }
                                            } ?> name="relationship[]" value="Separeret" type="checkbox"/> Separeret
                                        </label></div>
                                </li>
                                <li>
                                    <div class="checkbox">
                                        <label><input <?php if ($relationship) {
                                                for ($i = 0; $i < count($relationship); $i++) {
                                                    if ($relationship[$i] == 'Skilt') {
                                                        echo 'checked="true"';
                                                    }
                                                }
                                            } ?> name="relationship[]" value="Skilt" type="checkbox"/> Skilt</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="checkbox">
                                        <label><input <?php if ($relationship) {
                                                for ($i = 0; $i < count($relationship); $i++) {
                                                    if ($relationship[$i] == 'Enke/enkemand') {
                                                        echo 'checked="true"';
                                                    }
                                                }
                                            } ?> name="relationship[]" value="Enke/enkemand" type="checkbox"/>
                                            Enke/enkemand</label></div>
                                </li>
                                <li>
                                    <div class="checkbox">
                                        <label><input <?php if ($relationship) {
                                                for ($i = 0; $i < count($relationship); $i++) {
                                                    if ($relationship[$i] == 'Det får du at vide senere') {
                                                        echo 'checked="true"';
                                                    }
                                                }
                                            } ?> name="relationship[]" value="Det får du at vide senere"
                                                 type="checkbox"/> Det
                                            får du at vide senere</label></div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Børn</label>
                        <div id="list5" class="dropdown-check-list" tabindex="100">
                            <span class="anchor">Alle</span>
                            <ul id="items5" class="items">
                                <li>
                                    <div class="checkbox">
                                        <label><input <?php if ($children) {
                                                for ($i = 0; $i < count($children); $i++) {
                                                    if ($children[$i] == 'Nej') {
                                                        echo 'checked="true"';
                                                    }
                                                }
                                            } ?> name="children[]" value="Nej" type="checkbox"/> Nej</label></div>
                                </li>
                                <li>
                                    <div class="checkbox">
                                        <label><input <?php if ($children) {
                                                for ($i = 0; $i < count($children); $i++) {
                                                    if ($children[$i] == 'Ja, hjemmeboende') {
                                                        echo 'checked="true"';
                                                    }
                                                }
                                            } ?> name="children[]" value="Ja, hjemmeboende" type="checkbox"/> Ja,
                                            hjemmeboende</label></div>
                                </li>
                                <li>
                                    <div class="checkbox">
                                        <label><input <?php if ($children) {
                                                for ($i = 0; $i < count($children); $i++) {
                                                    if ($children[$i] == 'Ja, udeboende') {
                                                        echo 'checked="true"';
                                                    }
                                                }
                                            } ?> name="children[]" value="Ja, udeboende" type="checkbox"/> Ja, udeboende</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="checkbox">
                                        <label><input <?php if ($children) {
                                                for ($i = 0; $i < count($children); $i++) {
                                                    if ($children[$i] == '1') {
                                                        echo 'checked="true"';
                                                    }
                                                }
                                            } ?> name="children[]" value="1" type="checkbox"/> 1</label></div>
                                </li>
                                <li>
                                    <div class="checkbox">
                                        <label><input <?php if ($children) {
                                                for ($i = 0; $i < count($children); $i++) {
                                                    if ($children[$i] == '2') {
                                                        echo 'checked="true"';
                                                    }
                                                }
                                            } ?> name="children[]" value="2" type="checkbox"/> 2</label></div>
                                </li>
                                <li>
                                    <div class="checkbox">
                                        <label><input <?php if ($children) {
                                                for ($i = 0; $i < count($children); $i++) {
                                                    if ($children[$i] == '3') {
                                                        echo 'checked="true"';
                                                    }
                                                }
                                            } ?> name="children[]" value="3" type="checkbox"/> 3</label></div>
                                </li>
                                <li>
                                    <div class="checkbox">
                                        <label><input <?php if ($children) {
                                                for ($i = 0; $i < count($children); $i++) {
                                                    if ($children[$i] == '3+') {
                                                        echo 'checked="true"';
                                                    }
                                                }
                                            } ?> name="children[]" value="3+" type="checkbox"/> 3+</label></div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Etnisk oprindelse</label>
                        <div id="list4" class="dropdown-check-list" tabindex="100">
                            <span class="anchor">Alle</span>
                            <ul id="items4" class="items">
                                <li><input <?php if ($ethnic_origin) {
                                        for ($i = 0; $i < count($ethnic_origin); $i++) {
                                            if ($ethnic_origin[$i] == 'Europæisk') {
                                                echo 'checked="true"';
                                            }
                                        }
                                    } ?> name="ethnic_origin[]" value="Europæisk" type="checkbox"/> Europæisk
                                </li>
                                <li><input <?php if ($ethnic_origin) {
                                        for ($i = 0; $i < count($ethnic_origin); $i++) {
                                            if ($ethnic_origin[$i] == 'Sort/afrikansk') {
                                                echo 'checked="true"';
                                            }
                                        }
                                    } ?> name="ethnic_origin[]" value="Afrikansk" type="checkbox"/> Afrikansk
                                </li>
                                <li><input <?php if ($ethnic_origin) {
                                        for ($i = 0; $i < count($ethnic_origin); $i++) {
                                            if ($ethnic_origin[$i] == 'Latinamerikansk') {
                                                echo 'checked="true"';
                                            }
                                        }
                                    } ?> name="ethnic_origin[]" value="Latinamerikansk" type="checkbox"/>
                                    Latinamerikansk
                                </li>
                                <li><input <?php if ($ethnic_origin) {
                                        for ($i = 0; $i < count($ethnic_origin); $i++) {
                                            if ($ethnic_origin[$i] == 'Asiatisk') {
                                                echo 'checked="true"';
                                            }
                                        }
                                    } ?> name="ethnic_origin[]" value="Asiatisk" type="checkbox"/> Asiatisk
                                </li>
                                <li><input <?php if ($ethnic_origin) {
                                        for ($i = 0; $i < count($ethnic_origin); $i++) {
                                            if ($ethnic_origin[$i] == 'Indisk') {
                                                echo 'checked="true"';
                                            }
                                        }
                                    } ?> name="ethnic_origin[]" value="Indisk" type="checkbox"/> Indisk
                                </li>
                                <li><input <?php if ($ethnic_origin) {
                                        for ($i = 0; $i < count($ethnic_origin); $i++) {
                                            if ($ethnic_origin[$i] == 'Arabisk') {
                                                echo 'checked="true"';
                                            }
                                        }
                                    } ?> name="ethnic_origin[]" value="Arabisk" type="checkbox"/> Arabisk
                                </li>
                                <li><input <?php if ($ethnic_origin) {
                                        for ($i = 0; $i < count($ethnic_origin); $i++) {
                                            if ($ethnic_origin[$i] == 'Blandet/andet') {
                                                echo 'checked="true"';
                                            }
                                        }
                                    } ?> name="ethnic_origin[]" value="Blandet/andet" type="checkbox"/> Blandet/andet
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Religion</label>
                        <div id="list3" class="dropdown-check-list" tabindex="100">
                            <span class="anchor">Alle</span>
                            <ul id="items3" class="items">
                                <li><input <?php if ($religion) {
                                        for ($i = 0; $i < count($religion); $i++) {
                                            if ($religion[$i] == 'Agnostiker') {
                                                echo 'checked="true"';
                                            }
                                        }
                                    } ?> name="religion[]" value="Agnostiker" type="checkbox"/> Agnostiker
                                </li>
                                <li><input <?php if ($religion) {
                                        for ($i = 0; $i < count($religion); $i++) {
                                            if ($religion[$i] == 'Ateist') {
                                                echo 'checked="true"';
                                            }
                                        }
                                    } ?> name="religion[]" value="Ateist" type="checkbox"/> Ateist
                                </li>
                                <li><input <?php if ($religion) {
                                        for ($i = 0; $i < count($religion); $i++) {
                                            if ($religion[$i] == 'Buddhist') {
                                                echo 'checked="true"';
                                            }
                                        }
                                    } ?> name="religion[]" value="Buddhist" type="checkbox"/> Buddhist
                                </li>
                                <li><input <?php if ($religion) {
                                        for ($i = 0; $i < count($religion); $i++) {
                                            if ($religion[$i] == 'Kristen') {
                                                echo 'checked="true"';
                                            }
                                        }
                                    } ?> name="religion[]" value="Kristen" type="checkbox"/> Kristen
                                </li>
                                <li><input <?php if ($religion) {
                                        for ($i = 0; $i < count($religion); $i++) {
                                            if ($religion[$i] == 'Kristen – katolik') {
                                                echo 'checked="true"';
                                            }
                                        }
                                    } ?> name="religion[]" value="Kristen – katolik" type="checkbox"/> Kristen – katolik
                                </li>
                                <li><input <?php if ($religion) {
                                        for ($i = 0; $i < count($religion); $i++) {
                                            if ($religion[$i] == 'Jøde') {
                                                echo 'checked="true"';
                                            }
                                        }
                                    } ?> name="religion[]" value="Jøde" type="checkbox"/> Jøde
                                </li>
                                <li><input <?php if ($religion) {
                                        for ($i = 0; $i < count($religion); $i++) {
                                            if ($religion[$i] == 'Hindu') {
                                                echo 'checked="true"';
                                            }
                                        }
                                    } ?> name="religion[]" value="Hindu" type="checkbox"/> Hindu
                                </li>
                                <li><input <?php if ($religion) {
                                        for ($i = 0; $i < count($religion); $i++) {
                                            if ($religion[$i] == 'Muslim') {
                                                echo 'checked="true"';
                                            }
                                        }
                                    } ?> name="religion[]" value="Muslim" type="checkbox"/> Muslim
                                </li>
                                <li><input <?php if ($religion) {
                                        for ($i = 0; $i < count($religion); $i++) {
                                            if ($religion[$i] == 'Spirituel') {
                                                echo 'checked="true"';
                                            }
                                        }
                                    } ?> name="religion[]" value="Spirituel" type="checkbox"/> Spirituel
                                </li>
                                <li><input <?php if ($religion) {
                                        for ($i = 0; $i < count($religion); $i++) {
                                            if ($religion[$i] == 'Andet') {
                                                echo 'checked="true"';
                                            }
                                        }
                                    } ?> name="religion[]" value="Andet" type="checkbox"/> Andet
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Uddannelse</label>
                        <div id="list2" class="dropdown-check-list" tabindex="100">
                            <span class="anchor">Alle</span>
                            <ul id="items2" class="items">
                                <li><input <?php if ($training) {
                                        for ($i = 0; $i < count($training); $i++) {
                                            if ($training[$i] == 'Ingen eksamen') {
                                                echo 'checked="true"';
                                            }
                                        }
                                    } ?> name="training[]" value="Ingen eksamen" type="checkbox"/> Ingen eksamen
                                </li>
                                <li><input <?php if ($training) {
                                        for ($i = 0; $i < count($training); $i++) {
                                            if ($training[$i] == 'Gymnasium/HF') {
                                                echo 'checked="true"';
                                            }
                                        }
                                    } ?> name="training[]" value="Gymnasium/HF" type="checkbox"/> Gymnasium/HF
                                </li>
                                <li><input <?php if ($training) {
                                        for ($i = 0; $i < count($training); $i++) {
                                            if ($training[$i] == 'Fagskole') {
                                                echo 'checked="true"';
                                            }
                                        }
                                    } ?> name="training[]" value="Fagskole" type="checkbox"/> Fagskole
                                </li>
                                <li><input <?php if ($training) {
                                        for ($i = 0; $i < count($training); $i++) {
                                            if ($training[$i] == 'Bachelorgrad') {
                                                echo 'checked="true"';
                                            }
                                        }
                                    } ?> name="training[]" value="Bachelorgrad" type="checkbox"/> Bachelorgrad
                                </li>
                                <li><input <?php if ($training) {
                                        for ($i = 0; $i < count($training); $i++) {
                                            if ($training[$i] == 'Kandidat/ph.d.') {
                                                echo 'checked="true"';
                                            }
                                        }
                                    } ?> name="training[]" value="Kandidat/ph.d." type="checkbox"/> Kandidat/ph.d.
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Kropsbygning</label>
                        <div id="list1" class="dropdown-check-list" tabindex="100">
                            <span class="anchor">Alle</span>
                            <ul id="items" class="items">
                                <li><input <?php if ($body) {
                                        for ($i = 0; $i < count($body); $i++) {
                                            if ($body[$i] == 'Slank') {
                                                echo 'checked="true"';
                                            }
                                        }
                                    } ?> name="body[]" value="Slank" type="checkbox"/> Slank
                                </li>
                                <li><input <?php if ($body) {
                                        for ($i = 0; $i < count($body); $i++) {
                                            if ($body[$i] == 'Atletisk') {
                                                echo 'checked="true"';
                                            }
                                        }
                                    } ?> name="body[]" value="Atletisk" type="checkbox"/> Atletisk
                                </li>
                                <li><input <?php if ($body) {
                                        for ($i = 0; $i < count($body); $i++) {
                                            if ($body[$i] == 'Gennemsnitlig') {
                                                echo 'checked="true"';
                                            }
                                        }
                                    } ?> name="body[]" value="Gennemsnitlig" type="checkbox"/> Gennemsnitlig
                                </li>
                                <li><input <?php if ($body) {
                                        for ($i = 0; $i < count($body); $i++) {
                                            if ($body[$i] == 'Buttet') {
                                                echo 'checked="true"';
                                            }
                                        }
                                    } ?> name="body[]" value="Buttet" type="checkbox"/> Buttet
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Kyger</label>
                        <div id="list7" class="dropdown-check-list" tabindex="100">
                            <span class="anchor">Alle</span>
                            <ul id="items7" class="items">
                                <li><input <?php if ($smoking) {
                                        for ($i = 0; $i < count($smoking); $i++) {
                                            if ($smoking[$i] == 'Ja') {
                                                echo 'checked="true"';
                                            }
                                        }
                                    } ?> name="smoking[]" value="Ja" type="checkbox"/> Ja
                                </li>
                                <li><input <?php if ($smoking) {
                                        for ($i = 0; $i < count($smoking); $i++) {
                                            if ($smoking[$i] == 'Nej') {
                                                echo 'checked="true"';
                                            }
                                        }
                                    } ?> name="smoking[]" value="Nej" type="checkbox"/> Nej
                                </li>
                                <li><input <?php if ($smoking) {
                                        for ($i = 0; $i < count($smoking); $i++) {
                                            if ($smoking[$i] == 'Ja, festryger') {
                                                echo 'checked="true"';
                                            }
                                        }
                                    } ?> name="smoking[]" value="Ja, festryger" type="checkbox"/> Ja, festryger
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Afstand</label>
                        <input type="text" id="range_50" value=""/>
                    </div>
                    <button type="submit" class="btn btnSearch">Gem og søg</button>
                    <?php echo form_close(); ?>
                </div>
            </div>
            <div class="col-md-9 content-right">
                <div class="search-all">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3><?php echo $num; ?>+ profiler fundet</h3>
                            <h4>Aliquam tincidunt mauris eu risus</h4>
                            <p>Nu kan du tage Zeduuce.dk med i lommen og lade kærligheden blomstre uanset om du sidder i
                                bussen, eller nyder en kop kaffe på din yndlingscafé. Med vores apps til både iPhone og
                                Android telefoner er din nye flirt altid i nærheden, så I endnu hurtigere kan lære
                                hinanden at kende. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio.
                                Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh,
                                viverra non, semper suscipit, posuere a, pede.</p>
                        </div>
                    </div>
                    <?php if ($invita) { ?>
                        <div class="row">
                            <div class="col-xs-3 col-md-2 pull-right">
                                <button type="button" onclick="sendUserSearch('<?php echo $invita; ?>')"
                                        class="btn btnSearch">Tilføj
                                </button>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="all-result">
                        <div class="row">
                            <?php echo form_open('invitationer/chooseUserSearch', array('id' => 'frm_chooseUserSearch')); ?>
                            <?php
                            if ($list) {
                                $j = 0;
                                foreach ($list as $row) {
                                    if ($favorite) {
                                        if ($favorite[$j]['id'] > 0) {
                                            $check = 1;
                                        } else {
                                            $check = "";
                                        }
                                    } else {
                                        $check = "";
                                    }
                                    ?>
                                    <input type="hidden" name="listUser[]" value="<?php echo $row['id']; ?>"/>
                                    <div class="col-md-3 col-xs-6 item_people">
                                        <div class="img-people">
                                            <a id="favorite_<?php echo $row['id']; ?>" <?php if ($user) { ?><?php if (!$check) { ?> href="javascript:void(0)" onclick="addFavorite('<?php echo $row['id']; ?>');" <?php }
                                            } else { ?> href="#Flogin" data-toggle="modal" <?php } ?>
                                               class="i_favourite <?php if ($check) {
                                                   echo 'i_favourite_active';
                                               } ?>"></a>
                                            <a class="box_img_people"
                                               href="<?php echo site_url('user/profile/' . $row['id'] . '/' . seoUrl($row['name'])) ?>">
                                                <?php echo modules::run('left/left/avatar', (object)$row, 150, 150); ?>

                                            </a>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-10">
                                                <p class="name">
                                                    <a href="<?php echo site_url('user/profile/' . $row['id'] . '/' . seoUrl($row['name'])) ?>">
                                                        <?php echo $row['name']; ?>
                                                    </a>
                                                </p>
                                                <!--<p class="profile_number">Profilenr. : <?php /*echo $row['id'];*/
                                                ?></p>-->
                                                <?php if ($row['birthday']) {
                                                    $yearold = date('Y', time()) - explode('/', $row['birthday'])[2];
                                                } else {
                                                    $yearold = "";
                                                } ?>
                                                <p class="age">Age: <?php echo $yearold; ?></p>
                                                <p class="postcode">Postnr. : <?php echo $row['code']; ?></p>
                                            </div>
                                            <div class="col-xs-2" style="padding-left: 0px;">
                                                <p class="pull-right mt10"><span class="status-online"></span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php $j++;
                                }
                            } else {
                                ?>
                                <div class="col-md-3 col-xs-6 item_people">
                                    <p>Der er ingen data!</p>
                                </div>
                            <?php } ?>
                            <?php echo form_close(); ?>
                        </div>
                        <hr class="cc1c1c1"/>
                        <div class="row">
                            <div class="col-md-6">
                                <?php echo form_open('user/changePerPage', array('id' => 'perPageForm')); ?>
                                <div class="row">
                                    <div class="col-xs-5">
                                        <label class="mt5" for="">Profiler i hver side</label>
                                    </div>
                                    <div class="col-xs-4">
                                        <select name="perPage" class="form-control" id="perPage">
                                            <?php
                                            for ($i = 4; $i <= 20; $i += 4) {
                                                ?>
                                                <option value="<?php echo $i; ?>" <?php if ($i == $perPage) echo 'selected'; ?>><?php echo $i; ?>
                                                    profiler
                                                </option>
                                            <?php } ?>
                                            <option value="50" <?php if (50 == $perPage) echo 'selected'; ?>>50 profiler</option>
                                            <option value="100" <?php if (100 == $perPage) echo 'selected'; ?>>100 profiler</option>
                                        </select>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                            <div class="col-md-6">
                                <ul class="pagination pagination-sm pull-right">
                                    <?php echo $pagination; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $(document).ready(function () {
        $('#menu_browsing').addClass('active');
    });
</script>