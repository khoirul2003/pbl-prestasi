<?php

namespace App\Notifications;

use App\Models\RecommendationResult;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RecommendationNotification extends Notification
{
    use Queueable;

    protected $recommendationResult;

    public function __construct(RecommendationResult $recommendationResult)
    {
        $this->recommendationResult = $recommendationResult;
    }

    public function via($notifiable)
    {
        return ['mail'];  // Menggunakan email
    }

    public function toMail($notifiable)
    {
        $student = $this->recommendationResult->user;
        $detailStudent = $student->detailStudent; 
        $competition = $this->recommendationResult->competition;

        return (new MailMessage)
            ->subject('Rekomendasi untuk Kompetisi ' . $competition->competition_name)
            ->greeting('Halo ' . $student->user_name . ',')
            ->line('Kami ingin memberitahukan Anda bahwa Anda telah diterima dalam rekomendasi untuk kompetisi berikut:')
            ->line('Kompetisi: ' . $competition->competition_name)
            ->line('Skor Rekomendasi: ' . $this->recommendationResult->recommendation_result_score)
            ->line('Kami berharap Anda dapat mengikuti kompetisi ini dengan baik!')
            ->action('Lihat Kompetisi', url(route('competitions.show', $competition->competition_id)))
            ->line('Terima kasih atas partisipasi Anda dan semoga sukses!')
            ->to($detailStudent->detail_student_email);
    }

    public function toArray($notifiable)
    {
        return [
            'competition_id' => $this->recommendationResult->competition_id,
            'user_id' => $this->recommendationResult->user_id,
            'recommendation_score' => $this->recommendationResult->recommendation_result_score,
        ];
    }
}
