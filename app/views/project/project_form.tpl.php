<?php include(DIR . 'app/views/common/header.tpl.php'); /* var_dump($websites); die; */?>
<script>
    $('#project-li').addClass('active');
</script>
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="<?php echo $token; ?>">
    <div class="panel panel-default">
        <div class="panel-head">
            <div class="panel-title">
                <i class="icon-layers panel-head-icon"></i>
                <span class="panel-title-text"><?php echo $page_title; ?></span>
            </div>
            <div class="panel-action">
                <button type="submit" class="btn btn-primary btn-gradient btn-icon" name="submit" data-toggle="tooltip" title="<?php echo $lang['common']['text_save']; ?>"><i class="far fa-save"></i></button>
                <a href="<?php echo URL . DIR_ROUTE . 'projects'; ?>" class="btn btn-white btn-icon" data-toggle="tooltip" title="<?php echo $lang['common']['text_back_to_list']; ?>"><i class="fa fa-reply"></i></a>
            </div>
        </div>
        <div class="panel-wrapper">
            <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-primary pt-3">
                <li class="nav-item">
                    <a class="nav-link active" href="#basic-info" data-toggle="tab"><i class="icon-home mr-2"></i><?php echo $lang['project']['text_basic_info']; ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#order" data-toggle="tab"><i class="fas fa-info"></i><?php echo " Details"; ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#staff" data-toggle="tab"><i class="icon-people mr-2"></i><?php echo $lang['project']['text_staff']; ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#task" data-toggle="tab"><i class="icon-tag mr-2"></i><?php echo $lang['project']['text_tasks']; ?></a>
                </li>
                <?php if (!empty($result['id'])) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="#payments" data-toggle="tab"><i class="icon-docs mr-2"></i><?php echo "Payments"; ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#documents" data-toggle="tab"><i class="icon-docs mr-2"></i><?php echo $lang['project']['text_documents']; ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#comment" data-toggle="tab"><i class="icon-tag mr-2"></i><?php echo $lang['project']['text_comments']; ?></a>
                    </li>
                <?php } ?>
            </ul>
            <div class="p-3">
                <div class="tab-content mt-3 pl-4 pr-4">
                    <div class="tab-pane active" id="basic-info">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label"><?php echo $lang['project']['text_project_name']; ?></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="icon-layers"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="project[name]" value="<?php echo $result['name'] ?>" placeholder="<?php echo $lang['project']['text_project_name']; ?>">
                                    </div>
                                </div>
                                <div class="form-group customer-search">
                                    <label class="col-form-label"><?php echo $lang['common']['text_customer']; ?></label>
                                    <div class="form-group">
                                        <select name="project[customer]" class="selectpicker" data-width="100%" data-live-search="true" title="<?php echo $lang['common']['text_customer']; ?>">
                                            <?php if ($customers) {
                                                foreach ($customers as $key => $value) { ?>
                                                    <option value="<?php echo $value['id']; ?>" data-tokens="<?php echo $value['company']; ?>" <?php if ($result['customer'] == $value['id']) {
                                                                                                                                                    echo "selected";
                                                                                                                                                } ?>><?php echo $value['company']; ?></option>
                                            <?php }
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label"><?php echo $lang['project']['text_billing_method']; ?></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-money-bill-alt"></i></span>
                                        </div>
                                        <select class="custom-select billing-method" name="project[billingmethod]">
                                            <option value="1" <?php if ($result['billing_method'] == 1) {
                                                                    echo "selected";
                                                                } ?>><?php echo $lang['project']['text_fixed_cost_for_project']; ?></option>
                                            <option value="2" <?php if ($result['billing_method'] == 2) {
                                                                    echo "selected";
                                                                } ?>><?php echo $lang['project']['text_based_on_project_hours']; ?></option>
                                            <option value="3" <?php if ($result['billing_method'] == 3) {
                                                                    echo "selected";
                                                                } ?>><?php echo $lang['project']['text_based_on_task_hours']; ?></option>
                                            <option value="4" <?php if ($result['billing_method'] == 4) {
                                                                    echo "selected";
                                                                } ?>><?php echo $lang['project']['text_based_on_staff_hours']; ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label"><?php echo $lang['common']['text_currency']; ?></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="icon-credit-card"></i></span>
                                        </div>
                                        <select name="project[currency]" class="custom-select" required>
                                            <?php if ($currency) {
                                                foreach ($currency as $key => $value) { ?>
                                                    <option value="<?php echo $value['id'] ?>" <?php if ($result['currency'] == $value['id']) {
                                                                                                    echo "selected";
                                                                                                } ?>><?php echo $value['name']; ?></option>
                                            <?php }
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group budget-cost">
                                    <label class="col-form-label"><?php echo $lang['project']['text_total_budget_cost']; ?></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="icon-wallet"></i></span>
                                        </div>
                                        <input type="text" class="form-control" value="<?php echo $result['total_cost'] ?>" name="project[totalcost]" placeholder="<?php echo $lang['project']['text_total_budget_cost']; ?>">
                                    </div>
                                </div>
                                <div class="form-group rate-hour">
                                    <label class="col-form-label"><?php echo $lang['project']['text_rate_per_hour']; ?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="project[ratehour]" value="<?php echo $result['rate_hour'] ?>" placeholder="<?php echo $lang['project']['text_rate_per_hour']; ?>">
                                        <div class="input-group-append">
                                            <span class="input-group-text font-12"><?php echo $lang['project']['text_per_hour']; ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group project-hours">
                                    <label class="col-form-label"><?php echo $lang['project']['text_project_hours']; ?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="project[projecthour]" value="<?php echo $result['project_hour'] ?>" placeholder="<?php echo $lang['project']['text_project_hours']; ?>">
                                        <div class="input-group-append">
                                            <span class="input-group-text font-12"><?php echo $lang['project']['text_hours']; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label"><?php echo $lang['project']['text_project_start_date']; ?></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="icon-calendar"></i></span>
                                        </div>
                                        <input type="text" class="form-control date" name="project[start_date]" value="<?php echo date_format(date_create($result['start_date']), 'd-m-Y'); ?>" placeholder="<?php echo $lang['project']['text_project_start_date']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label"><?php echo $lang['project']['text_project_due_date']; ?></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="icon-event"></i></span>
                                        </div>
                                        <input type="text" class="form-control date" name="project[due_date]" value="<?php echo date_format(date_create($result['due_date']), 'd-m-Y'); ?>" placeholder="<?php echo $lang['project']['text_project_due_date']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">% <?php echo $lang['project']['text_complete']; ?></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="icon-speedometer"></i></span>
                                        </div>
                                        <input type="number" class="form-control" name="project[completed]" value="<?php echo $result['completed'] ?>" placeholder="% <?php echo $lang['project']['text_complete']; ?>">
                                        <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Websites</label>
                                        <select name="project[website_id]" class="custom-select" required>
                                            <option disabled selected>Websites</option>
                                            <?php
                                                $select = "";
                                                foreach ($websites as $value) {
                                                    if($result['website_id'] == $value['id'])
                                                    {
                                                        $select = "selected";
                                                    }
                                            ?>
                                                <option <?php echo $select;?> value="<?php echo $value['id'];?>"><?php echo $value['name'];?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label"><?php echo $lang['common']['text_description']; ?></label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="icon-note"></i></span>
                                        </div>
                                        <textarea class="form-control" rows="5" name="project[description]" placeholder="<?php echo $lang['common']['text_description']; ?>"><?php echo $result['description'] ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="order">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label">Paper Type</label>
                                    <div class="form-group">
                                        <input type="hidden" name="project[order][id]" value="<?php if (isset($order)) {
                                                                                                    echo $order[0]["id"];
                                                                                                } else {
                                                                                                    echo "";
                                                                                                } ?>">
                                        <select name="project[order][paper_type]" class="selectpicker" data-width="100%">
                                            <option value="" selected="selected">Select Paper Type
                                            </option>
                                            <?php
                                            $select = "";
                                            $value = "";
                                            $paper_type = [
                                                "Essay",
                                                "Term paper",
                                                "Resesrch paper",
                                                "Course Word",
                                                "Thesis",
                                                "Assignment",
                                                "Exposition Writing",
                                                "Critical analysis",
                                                "Reflection paper",
                                                "Reflective Essay",
                                                "Analytical Essay",
                                                "Brief Overview",
                                                "Response Essay",
                                                "Response paper",
                                                "Argumentative Essay",
                                                "Contrast Essay",
                                                "Research Essay",
                                                "Literature Review",
                                                "Dissertation",
                                                "Dissertation Chapter - Abstract",
                                                "Dissertation Chapter - Introduction",
                                                "Dissertation Chapter - Literature Review",
                                                "Dissertation Chapter - Methodology",
                                                "Dissertation Chapter - Result",
                                                "Dissertation Chapter - Discussion",
                                                "Capstone Project",
                                                "Dissertation Chapter",
                                                "Reflective Writing",
                                                "Report",
                                                "Proofreading",
                                                "Lab Report",
                                                "PowerPoint Presentation",
                                                "Reaction Paper",
                                                "Rewriting",
                                                "Press Release",
                                                "Statement of Purpose",
                                                "Letter of Recommendation",
                                                "Project",
                                                "Book Report",
                                                "Book Review",
                                                "Movie Review",
                                                "Research Proposal",
                                                "Case Study",
                                                "Article",
                                                "Article Critique",
                                                "Annotated Bibliography",
                                                "Speech / Presentation",
                                                "Power Point Presentation (without speaker notes)",
                                                "Power Point Presentation (with speaker notes)",
                                                "Admission Essays",
                                                "Admission Services - Editing",
                                                "Scholarship Essay",
                                                "Personal Statement",
                                                "News Release",
                                                "Biography",
                                                "Business Plan",
                                                "EBooks",
                                                "Editing",
                                                "Formatting",
                                                "Quiz",
                                                "Multiple Choice Questions (Non Time Framed)",
                                                "Multiple Choice Questions (Time Framed)",
                                                "Math Problem",
                                                "Paraphrasing",
                                                "Resume",
                                                "Cover Letter",
                                                "Poster",
                                                "Other"
                                            ];
                                            foreach ($paper_type as $value) {
                                                if (isset($order)) {
                                                    if ($order[0]["paper_type"] == $value) {
                                                        $select = "selected";
                                                    } else {
                                                        $select = "";
                                                    }
                                                }
                                            ?>
                                                <option <?php echo $select; ?> value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                            <?php
                                            }
                                            ?>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label">Acadmic Level</label>
                                    <div class="form-group">
                                        <select name="project[order][academic_level]" id="academic_level" class="selectpicker" data-width="100%">
                                            <option value="" selected="selected">Select Academic Level
                                            </option>
                                            <?php
                                            $select = "";
                                            $value = "";
                                            $acadmic_level = [
                                                "A-Level / College",
                                                "Undergraduate / Diploma",
                                                "Master",
                                                "PhD",
                                            ];
                                            foreach ($acadmic_level as $value) {
                                                if (isset($order)) {
                                                    if ($order[0]["academic_level"] == $value) {
                                                        $select = "selected";
                                                    } else {
                                                        $select = "";
                                                    }
                                                }
                                            ?>
                                                <option <?php echo $select; ?> value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                            <?php
                                            }
                                            ?>

                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label">Subject</label>
                                    <div class="form-group">
                                        <select name="project[order][subject]" id="subject" class="selectpicker" data-width="100%">
                                            <option value="" selected="selected">Select Subject
                                            </option>
                                            <?php
                                            $value = "";
                                            $select = "";
                                            $subject = [
                                                "Accounting",
                                                "Anthropology",
                                                "Art and Architecture",
                                                "Aviation",
                                                "Biology",
                                                "Business",
                                                "CIPD",
                                                "Criminal Law",
                                                "Chemistry",
                                                "Child Care",
                                                "Communications",
                                                "Computer Science",
                                                "English ",
                                                "Ethics ",
                                                "Economics",
                                                "Education",
                                                "Electronics",
                                                "Engineering",
                                                "Family and Consumer Science",
                                                "Film and Theatre Studies",
                                                "Finance",
                                                "Geography",
                                                "Government and Politics",
                                                "Health Care ",
                                                "HND",
                                                "History",
                                                "Hospitality",
                                                "Human Resource",
                                                "International Relations",
                                                "Literature ",
                                                "Logistics ",
                                                "Law",
                                                "Management",
                                                "Marketing",
                                                "Mathematics",
                                                "Mass communication",
                                                "Medical ",
                                                "Media Studies",
                                                "Music",
                                                "Nursing",
                                                "Philosophy",
                                                "Physics",
                                                "Programming Language",
                                                "Project Management",
                                                "Psychology",
                                                "Public Relations",
                                                "Real Estate",
                                                "Recruitment",
                                                "Supply Chain",
                                                "Religion",
                                                "Science",
                                                "Social Science",
                                                "Sociology",
                                                "Sport Science",
                                                "Statistics",
                                                "Strategy and Planning",
                                                "Tourism",
                                                "World Literature",
                                                "Zoology",
                                                "Other",
                                            ];
                                            foreach ($subject as $value) {
                                                if (isset($order)) {
                                                    if ($order[0]["subject"] == $value) {
                                                        $select = "selected";
                                                    } else {
                                                        $select = "";
                                                    }
                                                }
                                            ?>
                                                <option <?php echo $select; ?> value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                            <?php
                                            }
                                            ?>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label">Expected Result</label>
                                    <div class="form-group">
                                        <select name="project[order][expected_result]" id="expected_result" class="selectpicker" data-width="100%">
                                            <option value="" selected="selected">Select Expected Result
                                            </option>
                                            <?php
                                            $value = "";
                                            $select = "";
                                            $expected_result = [
                                                "Pass",
                                                "C",
                                                "B",
                                                "A",
                                            ];
                                            foreach ($expected_result as $value) {
                                                if (isset($order)) {
                                                    if ($order[0]["expected_result"] == $value) {
                                                        $select = "selected";
                                                    } else {
                                                        $select = "";
                                                    }
                                                }
                                            ?>
                                                <option <?php echo $select; ?> value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                            <?php
                                            }
                                            ?>

                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label">Deadline</label>
                                    <div class="form-group">
                                        <select name="project[order][deadline]" id="deadline" class="selectpicker" data-width="100%">
                                            <option value="" selected="selected">Select Deadline
                                            </option>
                                            <?php
                                            $value = "";
                                            $select = "";
                                            $deadline = [
                                                "15",
                                                "10",
                                                "7",
                                                "5",
                                                "3",
                                                "2",
                                                "1",
                                                "12",
                                            ];
                                            foreach ($deadline as $value) {
                                                if (isset($order)) {
                                                    if ($order[0]["deadline"] == $value) {
                                                        $select = "selected";
                                                    } else {
                                                        $select = "";
                                                    }
                                                }
                                            ?>
                                                <option <?php echo $select; ?> value="<?php echo $value; ?>">
                                                    <?php echo $value;
                                                    if ($value == 12) {
                                                        echo " Hours";
                                                    } else if ($value == 1) {
                                                        echo " Day";
                                                    } else {
                                                        echo " Days";
                                                    }
                                                    ?>
                                                </option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label">Format of Citation</label>
                                    <div class="form-group">
                                        <select name="project[order][style]" id="style" class="selectpicker" data-width="100%">
                                            <option value="" selected="selected">Select Format of Citation
                                            </option>
                                            <?php
                                            $value = "";
                                            $select = "";
                                            $style = [
                                                "APA Referencing",
                                                "CBE Referencing",
                                                "Chicago Referencing",
                                                "Harvard Referencing",
                                                "MLA Referencing",
                                                "Oxford Referencing",
                                                "Turabian Referencing",
                                                "Vancouver Referencing",
                                                "Other Referencing",
                                            ];
                                            foreach ($style as $value) {
                                                if (isset($order)) {
                                                    if ($order[0]["style"] == $value) {
                                                        $select = "selected";
                                                    } else {
                                                        $select = "";
                                                    }
                                                }
                                            ?>
                                                <option <?php echo $select; ?> value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                            <?php
                                            }
                                            ?>

                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-form-label">Paper Topic</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="icon-layers"></i></span>
                                        </div>
                                        <input type="text" class="form-control" value="<?php if (isset($order)) {
                                                                                            echo $order[0]["paper_topic"];
                                                                                        } ?>" name="project[order][paper_topic]">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label class="col-form-label">No. of Pages</label>
                                <div class="input-group">
                                    <div class="input-group-prepend" id="input-number-decrement-pages" style="cursor: pointer;">
                                        <span class="input-group-text"><i class="fas fa-minus"></i></span>
                                    </div>
                                    <input type="text" readonly class="form-control text-center font-weight-bolder" id="number_of_pages" name="project[order][number_of_pages]" pattern="[0-9]" min="0" max="800" value="<?php if (isset($order)) {
                                                                                                                                                                                                                                echo $order[0]["number_of_pages"];
                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                echo "0";
                                                                                                                                                                                                                            } ?>">
                                    <div class="input-group-prepend" id="input-number-increment-pages" style="cursor: pointer;">
                                        <span class="input-group-text"><i class="fas fa-plus"></i></span>
                                    </div>
                                </div>
                                <div><span id="wordCounts"></span>Words</div>
                            </div>
                            <div class="col-md-3">
                                <label class="col-form-label">No. of Posters</label>
                                <div class="input-group">
                                    <div class="input-group-prepend" id="input-poster-decrement" style="cursor: pointer;">
                                        <span class="input-group-text"><i class="fas fa-minus"></i></span>
                                    </div>
                                    <input type="text" readonly class="form-control text-center font-weight-bolder" id="no_of_poster" name="project[order][no_of_poster]" pattern="[0-9]" min="0" max="50" value="<?php if (isset($order)) {
                                                                                                                                                                                                                        echo $order[0]["no_of_poster"];
                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                        echo "0";
                                                                                                                                                                                                                    } ?>">
                                    <div class="input-group-prepend" id="input-poster-increment" style="cursor: pointer;">
                                        <span class="input-group-text"><i class="fas fa-plus"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="col-form-label">No. of Citations</label>
                                <div class="input-group">
                                    <div class="input-group-prepend" id="input-citation-decrement" style="cursor: pointer;">
                                        <span class="input-group-text"><i class="fas fa-minus"></i></span>
                                    </div>
                                    <input type="text" readonly class="form-control text-center font-weight-bolder" id="no_of_reference" name="project[order][no_of_reference]" pattern="[0-9]" min="0" max="50" value="<?php if (isset($order)) {
                                                                                                                                                                                                                            echo $order[0]["no_of_reference"];
                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                            echo "0";
                                                                                                                                                                                                                        } ?>">
                                    <div class="input-group-prepend" id="input-citation-increment" style="cursor: pointer;">
                                        <span class="input-group-text"><i class="fas fa-plus"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="col-form-label">Powerpoint Slides</label>
                                <div class="input-group">
                                    <div class="input-group-prepend" id="input-slider-decrement" style="cursor: pointer;">
                                        <span class="input-group-text"><i class="fas fa-minus"></i></span>
                                    </div>
                                    <input type="text" readonly class="form-control text-center font-weight-bolder" id="ppt_slides" name="project[order][ppt_slides]" pattern="[0-9]" min="0" max="50" value="<?php if (isset($order)) {
                                                                                                                                                                                                                    echo $order[0]["ppt_slides"];
                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                    echo "0";
                                                                                                                                                                                                                } ?>">
                                    <div class="input-group-prepend" id="input-slider-increment">
                                        <span class="input-group-text"><i class="fas fa-plus"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row pt-3">
                            <div class="col-md-3 text-center">
                                <h3>Per PPt Slides</h3>
                                <h4><sub>£</sub> <span class="text-bold" id="ppt-slide"><?php if (isset($order)) {
                                                                                            echo $order[0]["ppt-slide-input"];
                                                                                        } else {
                                                                                            echo "0";
                                                                                        } ?></span></h4>
                                <input type="hidden" id="ppt-slide-input" name="project[order][ppt-slide-input]" value="<?php if (isset($order)) {
                                                                                                                            echo $order[0]["ppt-slide-input"];
                                                                                                                        } else {
                                                                                                                            echo "0";
                                                                                                                        } ?>">
                            </div>
                            <div class="col-md-3 text-center">
                                <h3>Per Page Cost</h3>
                                <h4><sub>£</sub> <span class="text-bold" id="per-page-cost"><?php if (isset($order)) {
                                                                                                echo $order[0]["per-page-cost-input"];
                                                                                            } else {
                                                                                                echo "0";
                                                                                            } ?></span></h4>
                                <input type="hidden" id="per-page-cost-input" name="project[order][per-page-cost-input]" value="<?php if (isset($order)) {
                                                                                                                                    echo $order[0]["per-page-cost-input"];
                                                                                                                                } else {
                                                                                                                                    echo "0";
                                                                                                                                } ?>">
                            </div>
                            <div class="col-md-3 text-center">
                                <h3>Per Poster Cost</h3>
                                <h4><sub>£</sub> <span class="text-bold" id="per-poster-price"><?php if (isset($order)) {
                                                                                                    echo $order[0]["per-poster-price-input"];
                                                                                                } else {
                                                                                                    echo "0";
                                                                                                } ?></span></h4>
                                <input type="hidden" id="per-poster-price-input" name="project[order][per-poster-price-input]" value="<?php if (isset($order)) {
                                                                                                                                            echo $order[0]["per-poster-price-input"];
                                                                                                                                        } else {
                                                                                                                                            echo "0";
                                                                                                                                        } ?>">
                            </div>
                            <div class="col-md-3 text-center">
                                <h3>Total Cost</h3>
                                <h4><sub>£</sub> <span class="text-bold" id="total-cost"><?php if (isset($order)) {
                                                                                                echo $order[0]["total-cost"];
                                                                                            } else {
                                                                                                echo "0";
                                                                                            } ?></span></h4>
                                <input type="hidden" id="total-cost-input" name="project[order][total-cost]" value="<?php if (isset($order)) {
                                                                                                                        echo $order[0]["total-cost"];
                                                                                                                    } else {
                                                                                                                        echo "0";
                                                                                                                    } ?>">
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="staff">
                        <div class="">
                            <table class="table table-input font-12">
                                <thead>
                                    <tr>
                                        <th><?php echo $lang['project']['text_staff']; ?></th>
                                        <th><?php echo $lang['project']['text_hours']; ?></th>
                                        <th><?php echo $lang['project']['text_rate_per_hour']; ?></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($result['staff']) {
                                        foreach ($result['staff'] as $key => $value) { ?>
                                            <tr>
                                                <td>
                                                    <select class="selectpicker" name="project[staff][<?php echo $key ?>][name]" data-width="100%" data-live-search="true" title="<?php echo $lang['project']['text_staff']; ?>">
                                                        <?php if ($staff) {
                                                            foreach ($staff as $staff_key => $staff_value) { ?>
                                                                <option value="<?php echo $staff_value['user_id']; ?>" <?php if ($value['name'] == $staff_value['user_id']) {
                                                                                                                            echo "selected";
                                                                                                                        } ?>><?php echo $staff_value['name'] . ' <small> (' . $staff_value['email'] . ')</small>'; ?></option>
                                                        <?php }
                                                        } ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-transparent" name="project[staff][<?php echo $key; ?>][hours]" value="<?php echo $value['hours'] ?>">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-transparent" name="project[staff][<?php echo $key; ?>][rate]" value="<?php echo $value['rate'] ?>">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#" class="delete font-20 mt-3" data-toggle="tooltip" data-placement="top" title="Delete"><i class="icon-close text-danger text-danger p-1 m-1"></i></a>
                                                </td>
                                            </tr>
                                        <?php  }
                                    } else { ?>
                                        <tr>
                                            <td>
                                                <select class="selectpicker" name="project[staff][0][name]" data-width="100%" data-live-search="true" title="<?php echo $lang['project']['text_staff']; ?>">
                                                    <?php if ($staff) {
                                                        foreach ($staff as $staff_key => $staff_value) { ?>
                                                            <option value="<?php echo $staff_value['user_id']; ?>"><?php echo $staff_value['name'] . ' <small> (' . $staff_value['email'] . ')</small>'; ?></option>
                                                    <?php }
                                                    } ?>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="form-transparent" name="project[staff][0][hours]" value="">
                                            </td>
                                            <td>
                                                <input type="text" class="form-transparent" name="project[staff][0][rate]" value="">
                                            </td>
                                            <td class="text-center">
                                                <a href="#" class="delete font-20 mt-3" data-toggle="tooltip" data-placement="top" title="<?php echo $lang['common']['text_delete']; ?>"><i class="icon-close text-danger text-danger p-1 m-1"></i></a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="mb-3 mt-3">
                            <a href="#" class="btn btn-success btn-sm add-staff"><i class="icon-plus mr-2"></i> <?php echo $lang['common']['text_add'] . ' ' . $lang['project']['text_staff']; ?></a>
                        </div>
                    </div>
                    <div class="tab-pane" id="task">
                        <div class="table-responsive">
                            <table class="table table-input font-12">
                                <thead>
                                    <tr>
                                        <th><?php echo $lang['project']['text_task_name']; ?></th>
                                        <th><?php echo $lang['project']['text_description']; ?></th>
                                        <th><?php echo $lang['project']['text_rate_per_hour']; ?></th>
                                        <th><?php echo $lang['project']['text_work_hours']; ?> (HH)</th>
                                        <th><?php echo $lang['common']['text_status']; ?></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($result['task']) {
                                        foreach ($result['task'] as $key => $value) { ?>
                                            <tr>
                                                <td>
                                                    <input type="text" name="project[task][<?php echo $key ?>][name]" value="<?php echo $value['name'] ?>" class="form-transparent">
                                                </td>
                                                <td>
                                                    <input type="text" name="project[task][<?php echo $key ?>][description]" value="<?php echo $value['description'] ?>" class="form-transparent">
                                                </td>
                                                <td>
                                                    <input type="text" name="project[task][<?php echo $key ?>][ratehour]" value="<?php echo $value['ratehour'] ?>" class="form-transparent">
                                                </td>
                                                <td>
                                                    <input type="text" name="project[task][<?php echo $key ?>][budgethour]" value="<?php echo $value['budgethour'] ?>" class="form-transparent">
                                                </td>
                                                <td>
                                                    <select name="project[task][<?php echo $key ?>][status]" class="custom-select">
                                                        <option><?php echo $lang['common']['text_status']; ?></option>
                                                        <option value="1" <?php if ($value['status'] == "1") {
                                                                                echo "selected";
                                                                            } ?>><?php echo $lang['project']['text_started']; ?></option>
                                                        <option value="2" <?php if ($value['status'] == "2") {
                                                                                echo "selected";
                                                                            } ?>><?php echo $lang['project']['text_in_process']; ?></option>
                                                        <option value="3" <?php if ($value['status'] == "3") {
                                                                                echo "selected";
                                                                            } ?>><?php echo $lang['project']['text_testing']; ?></option>
                                                        <option value="4" <?php if ($value['status'] == "4") {
                                                                                echo "selected";
                                                                            } ?>><?php echo $lang['project']['text_completed']; ?></option>
                                                    </select>
                                                </td>
                                                <td class="text-center">
                                                    <a href="#" class="delete font-20 mt-3" data-toggle="tooltip" data-placement="top" title="<?php echo $lang['common']['text_delete']; ?>"><i class="icon-close text-danger text-danger p-1 m-1"></i></a>
                                                </td>
                                            </tr>
                                        <?php  }
                                    } else { ?>
                                        <tr>
                                            <td>
                                                <input type="text" name="project[task][0][name]" class="form-transparent">
                                            </td>
                                            <td>
                                                <input type="text" name="project[task][0][description]" class="form-transparent">
                                            </td>
                                            <td>
                                                <input type="text" name="project[task][0][ratehour]" class="form-transparent">
                                            </td>
                                            <td>
                                                <input type="text" name="project[task][0][budgethour]" class="form-transparent">
                                            </td>
                                            <td>
                                                <select name="project[task][0][status]" class="custom-select">
                                                    <option><?php echo $lang['common']['text_status']; ?></option>
                                                    <option value="1"><?php echo $lang['project']['text_started']; ?></option>
                                                    <option value="2"><?php echo $lang['project']['text_in_process']; ?></option>
                                                    <option value="3"><?php echo $lang['project']['text_testing']; ?></option>
                                                    <option value="4"><?php echo $lang['project']['text_completed']; ?></option>
                                                </select>
                                            </td>
                                            <td class="text-center">
                                                <a href="#" class="delete font-20 mt-3" data-toggle="tooltip" data-placement="top" title="<?php echo $lang['common']['text_delete']; ?>"><i class="icon-close text-danger text-danger p-1 m-1"></i></a>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                </tbody>
                            </table>
                        </div>
                        <div class="mb-3 mt-3">
                            <a href="#" class="btn btn-success btn-sm add-task"><i class="icon-plus mr-2"></i> <?php echo $lang['project']['text_add_task']; ?></a>
                        </div>
                    </div>
                    <?php if (!empty($result['id'])) { ?>
                        <div class="tab-pane" id="payments">
                            <div class="table-responsive">
                            <table class="table table-input font-12">
                                <thead>
                                <tr class="text-center" style="font-size:17px;">
                                        <th>Name</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        foreach($gateway as $value)
                                        {
                                    ?>
                                        <tr class="text-center" style="font-size:15px;">
                                            <td>
                                            <?php echo $value["name"]?>    
                                            </td>
                                            <td>
                                            <?php echo $value["amount"]?>    
                                            </td>
                                        </tr>
                                    <?php
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        </div>
                        <div class="tab-pane" id="documents">
                            <div class="form-group row pb-3">
                                <div class="attach-file col-md-10">
                                    <a data-toggle="modal" class="text-white bg-primary" data-target="#attach-file"><?php echo $lang['project']['text_upload_documents']; ?></a>
                                </div>
                            </div>
                            <div class="attached-files">
                                <?php if (!empty($documents)) {
                                    foreach ($documents as $key => $value) {
                                        $file_ext = pathinfo($value['file_name'], PATHINFO_EXTENSION);
                                        if ($file_ext == "pdf") { ?>
                                            <div class="attached-files-block">
                                                <a href="public/uploads/<?php echo $value['file_name']; ?>" class="open-pdf"><i class="fa fa-file-pdf-o"></i></a>
                                                <input type="hidden" name="expense[attached][]" value="<?php echo $value['file_name']; ?>">
                                                <div class="delete-file"><a class="icon-trash"></a></div>
                                            </div>
                                        <?php } else { ?>
                                            <div class="attached-files-block">
                                                <a href="public/uploads/<?php echo $value['file_name']; ?>" data-fancybox="gallery"><img src="public/uploads/<?php echo $value['file_name']; ?>" alt=""></a>
                                                <input type="hidden" name="expense[attached][]" value="<?php echo $value['file_name']; ?>">
                                                <div class="delete-file"><a class="icon-trash"></a></div>
                                            </div>
                                <?php }
                                    }
                                } ?>
                            </div>
                        </div>
                        <div class="tab-pane" id="comment">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <textarea id="project-comment" rows="4" class="form-control"></textarea>
                                    </div>
                                    <div>
                                        <p id="comment-submit" class="btn btn-warning btn-sm m-o"><?php echo $lang['project']['text_add_comment']; ?></p>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <ul class="timeline">
                                        <?php if (!empty($comments)) {
                                            foreach ($comments as $key => $value) { ?>
                                                <li>
                                                    <div class="time"><small><?php echo $value['date_of_joining']; ?></small></div>
                                                    <div class="timeline-container">
                                                        <div class="arrow"></div>
                                                        <div class="description"><?php echo $value['comment']; ?></div>
                                                        <div class="author"><?php echo $value['user']; ?></div>
                                                    </div>
                                                </li>
                                        <?php }
                                        } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <input type="hidden" name="website_id" value="1">
            <input type="hidden" name="id" value="<?php echo $result['id']; ?>">
        </div>
        <div class="panel-footer">
            <div class="row">
                <div class="col-12 text-center">
                    <button type="submit" name="submit" class="btn btn-primary btn-gradient btn-pill"><?php echo $lang['common']['text_save']; ?></button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Attach File Modal -->
<div id="attach-file" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo $lang['project']['text_upload_documents']; ?></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="<?php echo URL . DIR_ROUTE . 'attachFile'; ?>" class="dropzone" id="attach-file-upload"></form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $lang['common']['text_close']; ?></button>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="public/css/jquery.fancybox.min.css">
<script src="public/js/jquery.fancybox.min.js"></script>

<script>
    var staff = "";
    <?php foreach ($staff as $key => $value) { ?>
        var temp = '<option value="<?php echo $value['user_id'] ?>" data-email="<?php echo $value['email'] ?>"><?php echo $value['name'] . ' <small> (' . $value['email'] . ')</small>' ?></option>';
        staff += temp;
    <?php } ?>
    $('#staff').on('click', '.add-staff', function() {
        var count = $('#staff table tr:last select').attr('name').split('[')[2];
        count = parseInt(count.split(']')[0]) + 1;
        $('#staff table tbody').append('<tr>' +
            '<td>' +
            '<select class="selectpicker" name="project[staff][' + count + '][name]" data-width="100%" data-live-search="true" title="<?php echo $lang['project']['text_staff']; ?>"></select>' +
            '</td>' +
            '<td>' +
            '<input type="text" class="form-transparent" name="project[staff][' + count + '][hours]" value="">' +
            '</td>' +
            '<td>' +
            '<input type="text" class="form-transparent" name="project[staff][' + count + '][rate]" value="">' +
            '</td>' +
            '<td class="text-center">' +
            '<a href="#" class="delete font-20 mt-3" data-toggle="tooltip" data-placement="top" title="Delete"><i class="icon-close text-danger text-danger p-1 m-1"></i></a>' +
            '</td></tr>');
        $('#staff table tr:last select').append(staff);
        $('#staff table tr:last select').selectpicker('refresh');

        return false;
    });

    $('#staff').on('click', '.delete', function() {
        $(this).parents('tr').remove();
    })

    $('body').on('change', '.billing-method', function() {
        var val = $(this).val();
        $('.budget-cost, .project-hours, .rate-hour').hide();
        if (val === "1") {
            $('.budget-cost').show();
        } else if (val === "2") {
            $('.project-hours').show();
            $('.rate-hour').show();
        } else if (val === "3") {

        } else if (val === "4") {

        }
    });
    <?php if ($result['billing_method'] == 1) { ?> $('.rate-hour, .project-hours').hide();
        $('.budget-cost').show();
    <?php } else if ($result['billing_method'] == 2) { ?> $('.budget-cost').hide();
        $('.rate-hour, .project-hours').show();
    <?php } ?>

    $('body').on('click', '#comment-submit', function() {
        var id = $('input[name="id"]').val(),
            comment = $('#project-comment').val(),
            comment_to = 'project';

        $.ajax({
            method: "POST",
            url: 'index.php?route=make_comment',
            data: {
                id: id,
                comment: comment,
                comment_to: comment_to
            },
            error: function() {
                toastr.error('Comment could not added', 'Server Error');
            },
            success: function(response) {
                $('#project-comment').val('');
                $('.timeline').prepend('<li>' +
                    '<div class="time"><small>Now</small></div>' +
                    '<div class="timeline-container">' +
                    '<div class="arrow"></div>' +
                    '<div class="description">' + comment + '</div>' +
                    '<div class="author">' + $('.menu-user-info p:nth-child(1)').text() + '</div>' +
                    '</div>' +
                    '</li>');
                toastr.success('Comment added Succefully', 'Success');
            }
        });
    });



    //********************************************
    //Add Task ***********************************
    //********************************************
    $('#task').on('click', '.add-task', function() {
        var count = $('#task table tr:last input').attr('name').split('[')[2];
        count = parseInt(count.split(']')[0]) + 1;
        $('#task table tbody').append('<tr><td>' +
            '<input type="text" name="project[task][' + count + '][name]" class="form-transparent">' +
            '</td>' +
            '<td>' +
            '<input type="text" name="project[task][' + count + '][description]" class="form-transparent">' +
            '</td>' +
            '<td>' +
            '<input type="text" name="project[task][' + count + '][ratehour]" class="form-transparent">' +
            '</td>' +
            '<td>' +
            '<input type="text" name="project[task][' + count + '][budgethour]" class="form-transparent">' +
            '</td>' +
            '<td>' +
            '<select name="project[task][' + count + '][status]" class="custom-select">' +
            '<option>Select Status</option>' +
            '<option value="1">Started</option>' +
            '<option value="2">In Process</option>' +
            '<option value="3">Testing</option>' +
            '<option value="4">Completed</option>' +
            '</select>' +
            '</td>' +
            '<td class="text-center">' +
            '<a href="#" class="delete font-20 mt-3" data-toggle="tooltip" data-placement="top" title="Delete"><i class="icon-close text-danger text-danger p-1 m-1"></i></a>' +
            '</td></tr>');

        return false;
    });

    $('#task').on('click', '.delete', function() {
        $(this).parents('tr').remove();
    })

    $(document).ready(function() {

        $("a.open-pdf").fancybox({
            'frameWidth': 800,
            'frameHeight': 900,
            'overlayShow': true,
            'hideOnContentClick': false,
            'type': 'iframe'
        });

        $("#attach-file-upload").dropzone({
            addRemoveLinks: true,
            acceptedFiles: "image/*,application/pdf",
            maxFilesize: 50000,
            dictDefaultMessage: '<?php echo $lang['common']['text_drop_message'] . '<br /><br />' . $lang['common']['text_allowed_file']; ?>',
            init: function() {
                this.on("sending", function(file, xhr, formData) {
                        var id = $('input[name=id]').val(),
                            type = 'project';
                        formData.append("id", id);
                        formData.append("type", type);
                    }),
                    this.on("success", function(file, xhr) {
                        var ext = file.xhr.response.substr(file.xhr.response.lastIndexOf('.') + 1);
                        if (ext === "pdf") {
                            $('.attached-files').append('<div class="attached-files-block attached-' + file.xhr.response.slice(0, -4) + '">' +
                                '<a href="public/uploads/' + file.xhr.response + '" class="open-pdf"><i class="fa fa-file-pdf-o"></i></a>' +
                                '<input type="hidden" name="expense[attached][]" value="' + file.xhr.response + '">' +
                                '<div class="delete-file"><a class="icon-trash"></a></div>' +
                                '</div>');
                        } else {
                            $('.attached-files').append('<div class="attached-files-block attached-' + file.xhr.response.slice(0, -4) + '">' +
                                '<a href="public/uploads/' + file.xhr.response + '" data-fancybox="gallery"><img src="public/uploads/' + file.xhr.response + '" alt=""></a>' +
                                '<input type="hidden" name="expense[attached][]" value="' + file.xhr.response + '">' +
                                '<div class="delete-file"><a class="icon-trash"></a></div>' +
                                '</div>');
                        }
                        toastr.success('Document added Succefully', 'Success');
                    })
            },
            renameFile: function(file) {
                return file.name.split('.')[0] + new Date().valueOf() + "." + file.name.split('.').pop();
            },
            removedfile: function(file) {
                var name = file.upload.filename;
                $.ajax({
                    type: 'POST',
                    url: 'index.php?route=attachFile/delete',
                    data: {
                        name: name,
                        type: 'project'
                    },
                    error: function() {
                        toastr.error('File could not be deleted', 'Server Error');
                    },
                    success: function(data) {
                        $('.attached-' + name.slice(0, -4) + '').remove();
                        toastr.success('File Deleted Succefully', 'Success');
                    }
                });
                var _ref;
                return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
            }
        });

        $('.attached-files-block').on('click', '.delete-file a', function() {
            var ele = $(this),
                name = ele.parents('.attached-files-block').find('input').val();
            $.ajax({
                type: 'POST',
                url: 'index.php?route=attachFile/delete',
                data: {
                    name: name,
                    type: 'project'
                },
                error: function() {
                    toastr.error('File could not be deleted', 'Server Error');
                },
                success: function(data) {
                    $('.attached-' + name.slice(0, -4) + '').remove();
                    toastr.success('File Deleted Succefully', 'Success');
                }
            });
            ele.parents('.attached-files-block').remove();
        });
    });
</script>
<script>
    const academic_level = document.querySelector('#academic_level');
    const expected_result = document.querySelector('#expected_result');
    const inputNumberDecrementPages = document.querySelector('#input-number-decrement-pages');
    const inputNumberIncrementPages = document.querySelector('#input-number-increment-pages');
    const numberOfPages = document.querySelector('#number_of_pages');
    const inputPosterDecrement = document.querySelector('#input-poster-decrement');
    const inputPosterIncrement = document.querySelector('#input-poster-increment');
    const noOfPoster = document.querySelector('#no_of_poster');
    const inputCitationDecrement = document.querySelector('#input-citation-decrement');
    const inputCitationIncrement = document.querySelector('#input-citation-increment');
    const no_of_reference = document.querySelector('#no_of_reference');
    const inputSliderDecrement = document.querySelector('#input-slider-decrement');
    const inputSliderIncrement = document.querySelector('#input-slider-increment');
    const pptSlidesInput = document.querySelector('#ppt_slides');
    const pptSlide = document.querySelector('#ppt-slide');
    const pptSlideInput = document.querySelector('#ppt-slide-input');
    const perPageCost = document.querySelector('#per-page-cost');
    const perPageCostInput = document.querySelector('#per-page-cost-input');
    const perPosterPrice = document.querySelector('#per-poster-price');
    const perPosterPriceInput = document.querySelector('#per-poster-price-input');
    const totalCost = document.querySelector('#total-cost');
    const deadLine = document.querySelector('#deadline');
    const wordCount = document.querySelector('#wordCounts');
    const totalCostInput = document.querySelector('#total-cost-input');
    const wordsPerPage = 250;
    let value = 0;
    let basePpt = 0;
    let basePoster = 0;
    let baseExpected = 0;
    let basePaper = 0;
    let pptIncrement = 0;
    let PosterIncrement = 0;
    let paperIncrement = 0;


    // increment function

    const increment = (val) => {
        return parseInt(val.value) + 1;
    }

    inputNumberIncrementPages.addEventListener('click', () => {
        numberOfPages.value = increment(numberOfPages);
        calculate();
    });

    inputPosterIncrement.addEventListener('click', () => {
        noOfPoster.value = increment(noOfPoster);
        calculate();
    });

    inputCitationIncrement.addEventListener('click', () => {
        no_of_reference.value = increment(no_of_reference);
    });

    inputSliderIncrement.addEventListener('click', () => {
        pptSlidesInput.value = increment(pptSlidesInput);
        calculate();
    });

    // increment function

    // decrement function

    const decrement = (val) => {
        if (parseInt(val.value) == 0) {
            value = 0;
        } else {
            value = parseInt(val.value) - 1;
        }
        return value;
    }

    inputNumberDecrementPages.addEventListener('click', () => {
        numberOfPages.value = decrement(numberOfPages);
        calculate();
    });

    inputPosterDecrement.addEventListener('click', () => {
        noOfPoster.value = decrement(noOfPoster);
        calculate();
    });

    inputCitationDecrement.addEventListener('click', () => {
        no_of_reference.value = decrement(no_of_reference);
    });

    inputSliderDecrement.addEventListener('click', () => {
        pptSlidesInput.value = decrement(pptSlidesInput);
        calculate();
    });

    // decrement function

    const setValue = () => {
        if (expected_result.value == 'Pass') {
            baseExpected = 0;
        } else if (expected_result.value == 'C') {
            baseExpected = 2;
        } else if (expected_result.value == 'B') {
            baseExpected = 4;
        } else if (expected_result.value == 'A') {
            baseExpected = 6;
        }

        if (academic_level.value == 'A-Level / College') {
            basePpt = 5;
            basePoster = 50;
            basePaper = 9;
        } else if (academic_level.value == 'Undergraduate / Diploma') {
            basePpt = 6;
            basePoster = 50;
            basePaper = 11;
        } else if (academic_level.value == 'Master') {
            basePpt = 7;
            basePoster = 50;
            basePaper = 13;
        } else if (academic_level.value == 'PhD') {
            basePpt = 8;
            basePoster = 50;
            basePaper = 15;
        }

        if (deadLine.value == '15') {
            pptIncrement = 0;
            PosterIncrement = 0;
            paperIncrement = 0;
        } else if (deadLine.value == "10") {
            pptIncrement = 1;
            PosterIncrement = 10;
            paperIncrement = 2;
        } else if (deadLine.value == "7") {
            pptIncrement = 2;
            PosterIncrement = 20;
            paperIncrement = 4;
        } else if (deadLine.value == "5") {
            pptIncrement = 3;
            PosterIncrement = 30;
            paperIncrement = 6;
        } else if (deadLine.value == "3") {
            pptIncrement = 4;
            PosterIncrement = 40;
            paperIncrement = 8
        } else if (deadLine.value == "2") {
            pptIncrement = 6;
            PosterIncrement = 50;
            paperIncrement = 10;
        } else if (deadLine.value == "1") {
            pptIncrement = 7;
            PosterIncrement = 70;
            paperIncrement = 8;
        } else if (deadLine.value == "12") {
            pptIncrement = 9;
            PosterIncrement = 90;
            paperIncrement = 10;
        } else if (deadLine.value == "6") {
            pptIncrement = 11;
            PosterIncrement = 110;
            paperIncrement = 12;
        }
    }
    const calculate = () => {
        setValue();
        if (numberOfPages.value != '0') {
            perPageCost.innerHTML = (basePaper + paperIncrement) + baseExpected;
            perPageCostInput.value = (basePaper + paperIncrement);
        } else {
            perPageCost.innerHTML = 0;
            perPageCostInput.value = 0;
        }
        if (noOfPoster.value != '0') {
            perPosterPrice.innerHTML = (basePoster + PosterIncrement);
            perPosterPriceInput.value = (basePoster + PosterIncrement);
        } else {
            perPosterPrice.innerHTML = 0;
            perPosterPriceInput.value = 0;
        }
        if (pptSlidesInput.value != '0') {
            pptSlide.innerHTML = (basePpt + pptIncrement);
            pptSlideInput.value = (basePpt + pptIncrement);
        } else {
            pptSlide.innerHTML = 0;
            pptSlideInput.value = 0;
        }
        if (numberOfPages.value != '0') {
            wordCount.innerHTML = parseInt(numberOfPages.value) * wordsPerPage;
        } else {
            wordCount.innerHTML = "";
        }
        const totalPageCost = (parseInt(perPageCost.innerHTML) * parseInt(numberOfPages.value));
        const totalPosterCost = (parseInt(perPosterPrice.innerHTML) * parseInt(noOfPoster.value));
        const totalSlidesCost = (parseInt(pptSlide.innerHTML) * parseInt(pptSlidesInput.value));
        totalCost.innerHTML = totalPageCost + totalPosterCost + totalSlidesCost;
        totalCostInput.value = totalPageCost + totalPosterCost + totalSlidesCost;
        console.log(perPageCostInput.value, perPosterPriceInput.value, pptSlideInput.value, totalCostInput.value);
    }
    academic_level.addEventListener('change', () => {
        calculate();
    });
    expected_result.addEventListener('change', () => {
        calculate();
    })
    deadLine.addEventListener('change', () => {
        calculate();
    })
</script>
<!-- Footer -->
<?php include(DIR . 'app/views/common/footer.tpl.php'); ?>