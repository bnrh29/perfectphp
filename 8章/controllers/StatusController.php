<?php

class StatusController extends Controller
{
    public function indexAction()
    {
        $usr = $this->session->get('user');
        $statuses = $this->db_manager->get('Status')->fetchAllPersonalArchivesByUserId($user['id']);
        return $this->render(array(
            'status' => $statuses,
            'body' => '',
            '_token' => $this->generateCsrfToken('status/post'),
        ));
    }
}
