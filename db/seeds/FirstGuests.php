<?php


use Phinx\Seed\AbstractSeed;

class FirstGuests extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $data = [
            [
                'name'    => 'John Doe',
                'created_at' => date('2018-01-04 10:00:00'),
                'email' => 'john.doe@gmail.com',
                'message' => 'Thanks for everything. It was super nice.',
            ],[
                'name'    => 'Jane Doe',
                'created_at' => date('2018-01-05 10:00:00'),
                'email' => 'jane.doe@gmail.com',
                'message' => 'Thanks for everything. It was super nice.',
            ]
        ];

        $posts = $this->table('messages');
        $posts->insert($data)
            ->save();
    }
}
