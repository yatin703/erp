<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Coex_track_my_order extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata("logged_in")) {
            $this->load->model("common_model");
            $this->load->model("trackmyorder_model");
        } else {
            redirect("login", "refresh");
        }
    }

    function index()
    {
        $data["page_name"] = "Production";
        $data["module"] = $this->common_model->select_active_module(
            $this->session->userdata["logged_in"]["user_id"],
            $this->session->userdata["logged_in"]["company_id"]
        );
        //echo $this->db->last_query();
        if ($data["module"] != false) {
            foreach ($data["module"] as $module_row) {
                if ($module_row->module_name === "Production") {
                    $data[
                        "formrights"
                    ] = $this->common_model->select_active_formrights_of_form(
                        $this->session->userdata["logged_in"]["user_id"],
                        $this->session->userdata["logged_in"]["company_id"],
                        5,
                        $this->router->fetch_class()
                    );

                    foreach ($data["formrights"] as $formrights_row) {
                        if ($formrights_row->view == 1) {
                            $data["page_name"] = "Production";
                            $data[
                                "module"
                            ] = $this->common_model->select_active_module(
                                $this->session->userdata["logged_in"][
                                    "user_id"
                                ],
                                $this->session->userdata["logged_in"][
                                    "company_id"
                                ]
                            );
                            $data["formrights"] = $this->common_model->select_active_formrights_of_form(
                                $this->session->userdata["logged_in"][
                                    "user_id"
                                ],
                                $this->session->userdata["logged_in"][
                                    "company_id"
                                ],
                                5,
                                $this->router->fetch_class()
                            );

                            $data[
                                "coex_track_order"
                            ] = $this->trackmyorder_model->active_coex_extrusion_track_order_record(
                                date("Y-m-01"),
                                date("Y-m-d")
                            );
                            //echo $this->db->last_query();

                            $this->load->view("Home/header");
                            $this->load->view("Home/nav", $data);
                            $this->load->view("Home/subnav");
                            $this->load->view(
                                ucwords($this->router->fetch_class()) .
                                    "/active-title",
                                $data
                            );
                            $this->load->view(
                                ucwords($this->router->fetch_class()) .
                                    "/search-form",
                                $data
                            );
                            $this->load->view(
                                ucwords($this->router->fetch_class()) .
                                    "/active-records",
                                $data
                            );

                            $this->load->view("Home/footer");
                        } else {
                            $data["note"] = "No rights Thanks";
                            $this->load->view("Home/header");
                            $this->load->view("Home/nav", $data);
                            $this->load->view("Home/subnav");
                            $this->load->view("Error/error-title", $data);
                            $this->load->view("Home/footer");
                        }
                    }
                }
            }
        } else {
            $data["note"] = "No rights Thanks";
            $data["page_name"] = "home";
            $data["module"] = $this->common_model->select_active_module(
                $this->session->userdata["logged_in"]["user_id"],
                $this->session->userdata["logged_in"]["company_id"]
            );
            $this->load->view("Home/header");
            $this->load->view("Home/nav", $data);
            $this->load->view("Home/subnav");
            $this->load->view("Error/error-title", $data);
            $this->load->view("Home/footer");
        }
    }

    function search_result()
    {
        $data["page_name"] = "Production";
        $data["module"] = $this->common_model->select_active_module(
            $this->session->userdata["logged_in"]["user_id"],
            $this->session->userdata["logged_in"]["company_id"]
        );
        if ($data["module"] != false) {
            foreach ($data["module"] as $module_row) {
                if ($module_row->module_name === "Production") {
                    $data[
                        "formrights"
                    ] = $this->common_model->select_active_formrights_of_form(
                        $this->session->userdata["logged_in"]["user_id"],
                        $this->session->userdata["logged_in"]["company_id"],
                        5,
                        $this->router->fetch_class()
                    );

                    foreach ($data["formrights"] as $formrights_row) {
                        if ($formrights_row->view == 1) {
                            $this->form_validation->set_rules(
                                "from_date",
                                "From Date",
                                "trim|xss_clean|exact_length[10]"
                            );
                            $this->form_validation->set_rules(
                                "to_date",
                                "To Date",
                                "trim|xss_clean|exact_length[10]"
                            );

                            if ($this->form_validation->run() == false) {
                                $data["page_name"] = "Production";
                                $data[
                                    "module"
                                ] = $this->common_model->select_active_module(
                                    $this->session->userdata["logged_in"][
                                        "user_id"
                                    ],
                                    $this->session->userdata["logged_in"][
                                        "company_id"
                                    ]
                                );

                                $data[
                                    "customer_category"
                                ] = $this->common_model->select_active_drop_down(
                                    "address_category_master",
                                    $this->session->userdata["logged_in"][
                                        "company_id"
                                    ]
                                );

                                $data[
                                    "sleeve_dia"
                                ] = $this->common_model->select_active_drop_down(
                                    "sleeve_diameter_master",
                                    $this->session->userdata["logged_in"][
                                        "company_id"
                                    ]
                                );

                                $data[
                                    "formrights"
                                ] = $this->common_model->select_active_formrights_of_form(
                                    $this->session->userdata["logged_in"][
                                        "user_id"
                                    ],
                                    $this->session->userdata["logged_in"][
                                        "company_id"
                                    ],
                                    5,
                                    $this->router->fetch_class()
                                );

                                $this->load->view("Home/header");
                                $this->load->view("Home/nav", $data);
                                $this->load->view("Home/subnav");
                                $this->load->view(
                                    ucwords($this->router->fetch_class()) .
                                        "/active-title",
                                    $data
                                );
                                $this->load->view(
                                    ucwords($this->router->fetch_class()) .
                                        "/search-form",
                                    $data
                                );
                                $this->load->view("Home/footer");
                            } else {
                                $data_search = [];

                                if ($this->input->post("order_no") != "") {
                                    $data_search[
                                        "order_no"
                                    ] = $this->input->post("order_no");
                                }

                                $from_date = "";
                                if (!empty($this->input->post("from_date"))) {
                                    $from_date = $this->input->post(
                                        "from_date"
                                    );
                                }

                                $to_date = "";
                                if (!empty($this->input->post("to_date"))) {
                                    $to_date = $this->input->post("to_date");
                                }

                                if ($from_date == "" && $to_date == "") {
                                    $from_date = date("Y-m-01");
                                    $to_date = date("Y-m-d");
                                }

                                $data[
                                    "coex_track_order"
                                ] = $this->trackmyorder_model->active_coex_extrusion_track_order_record(
                                    $from_date,
                                    $to_date
                                );
                                //echo $this->db->last_query();

                                $data["page_name"] = "Production";
                                $data[
                                    "module"
                                ] = $this->common_model->select_active_module(
                                    $this->session->userdata["logged_in"][
                                        "user_id"
                                    ],
                                    $this->session->userdata["logged_in"][
                                        "company_id"
                                    ]
                                );
                                $data[
                                    "formrights"
                                ] = $this->common_model->select_active_formrights_of_form(
                                    $this->session->userdata["logged_in"][
                                        "user_id"
                                    ],
                                    $this->session->userdata["logged_in"][
                                        "company_id"
                                    ],
                                    5,
                                    $this->router->fetch_class()
                                );
                                $data[
                                    "sleeve_dia"
                                ] = $this->common_model->select_active_drop_down(
                                    "sleeve_diameter_master",
                                    $this->session->userdata["logged_in"][
                                        "company_id"
                                    ]
                                );

                                $this->load->view("Home/header");
                                $this->load->view("Home/nav", $data);
                                $this->load->view("Home/subnav");
                                $this->load->view(
                                    ucwords($this->router->fetch_class()) .
                                        "/active-title",
                                    $data
                                );
                                $this->load->view(
                                    ucwords($this->router->fetch_class()) .
                                        "/active-records",
                                    $data
                                );
                                $this->load->view(
                                    ucwords($this->router->fetch_class()) .
                                        "/search-result",
                                    $data
                                );
                                $this->load->view("Home/footer");
                            }
                        } else {
                            $data["note"] = "No New rights Thanks";
                            $this->load->view("Home/header");
                            $this->load->view("Home/nav", $data);
                            $this->load->view("Home/subnav");
                            $this->load->view("Error/error-title", $data);
                            $this->load->view("Home/footer");
                        }
                    }
                }
            }
        } else {
            $data["note"] = "No New rights Thanks";
            $data["page_name"] = "home";
            $data["module"] = $this->common_model->select_active_module(
                $this->session->userdata["logged_in"]["user_id"],
                $this->session->userdata["logged_in"]["company_id"]
            );
            $this->load->view("Home/header");
            $this->load->view("Home/nav", $data);
            $this->load->view("Home/subnav");
            $this->load->view("Error/error-title", $data);
            $this->load->view("Home/footer");
        }
    }
}
