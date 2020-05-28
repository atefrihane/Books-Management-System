<?php

use Illuminate\Database\Seeder;
use App\Modules\Author\Models\Author;

class AuthorsTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $authors = [
            [
                'first_name' => 'Ernest ',
                'last_name' => 'Hemingway',
                'biography' => 'Ernest Miller Hemingway was an American journalist, novelist, short-story writer, and sportsman. His economical and understated style—which he termed the iceberg theory—had a strong influence on 20th-century fiction, while his adventurous lifestyle and his public image brought him admiration from later generations.',
                'photo' => '/img/authors/hemingway.jpg',
            ],

            [
                'first_name' => 'James ',
                'last_name' => 'Joyce',
                'biography' => 'James Augustine Aloysius Joyce was an Irish novelist, short story writer, poet, teacher, and literary critic. He contributed to the modernist avant-garde and is regarded as one of the most influential and important authors of the 20th century.',
                'photo' => '/img/authors/James-Joyce.jpg ',
            ],

            [
                'first_name' => 'William ',
                'last_name' => 'Shakespeare',
                'biography' => 'William Shakespeare was an English poet, playwright, and actor, widely regarded as the greatest writer in the English language and the world\'s greatest dramatist. He is often called England\'s national poet and the "Bard of Avon".',
                'photo' => '/img/authors/shakespeare.jpg ',
            ],

            [
                'first_name' => 'Sylvia ',
                'last_name' => 'Plath',
                'biography' => 'Sylvia Plath was an American poet, novelist, and short-story writer. She is credited with advancing the genre of confessional poetry and is best known for two of her published collections, The Colossus and Other Poems and Ariel, as well as The Bell Jar, a semi-autobiographical novel published shortly before her death.".',
                'photo' => '/img/authors/Sylvia-Plath.jpg ',
            ],

        ];
        Author::insert($authors);
    }
}
