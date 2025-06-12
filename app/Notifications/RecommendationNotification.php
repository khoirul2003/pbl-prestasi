<?php

namespace App\Notifications;

use App\Models\RecommendationResult;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class RecommendationNotification extends Notification
{
    use Queueable;

    protected $recommendationResult;

    public function __construct(RecommendationResult $recommendationResult)
    {
        $this->recommendationResult = $recommendationResult;
    }

    /**
     * Tentukan kanal yang digunakan untuk notifikasi (dalam hal ini, email).
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {

        return ['mail'];  // Menggunakan email
    }

    /**
     * Kirim email pemberitahuan rekomendasi.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $student = $notifiable;


        // $student = $this->recommendationResult->user;
        $competition = $this->recommendationResult->competition;
        // dd($competition->competition_tittle);


        return (new MailMessage)
            ->subject('Rekomendasi untuk Kompetisi ' . $competition->competition_tittle)
            ->greeting('Halo ' . $student->user->user_name . ',')
            ->line('Kami ingin memberitahukan Anda bahwa Anda telah diterima dalam rekomendasi untuk kompetisi berikut:')
            ->line('Kompetisi: ' . $competition->competition_tittle)
            ->line('Skor Rekomendasi: ' . $this->recommendationResult->recommendation_result_score)
            ->line('Kami berharap Anda dapat mengikuti kompetisi ini dengan baik!')
            ->action('Lihat Kompetisi', url(route('student.recommendations.index')))
            ->line('Terima kasih atas partisipasi Anda dan semoga sukses!');
    }

    /**
     * Menentukan bagaimana notifikasi ini akan disimpan dalam database (jika diinginkan).
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'competition_id' => $this->recommendationResult->competition_id,
            'user_id' => $this->recommendationResult->user_id,
            'recommendation_score' => $this->recommendationResult->recommendation_result_score,
        ];
    }
}
