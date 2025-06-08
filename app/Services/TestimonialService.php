<?php
namespace App\Services;

use App\Repositories\TestimonialRepository;

class TestimonialService
{
    protected $testimonialRepo;

    public function __construct(TestimonialRepository $testimonialRepo)
    {
        $this->testimonialRepo = $testimonialRepo;
    }

    public function getTestimonials($status = 'active')
    {
        return $this->testimonialRepo->getAllTestimonials($status);
    }
}