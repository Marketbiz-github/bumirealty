<?php
namespace App\Services;

use App\Repositories\TestimonialRepository;
use Illuminate\Support\Str;

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

    public function create($data)
    {
        $data['id'] = Str::uuid();
        return $this->testimonialRepo->create($data);
    }

    public function find($id)
    {
        return $this->testimonialRepo->findById($id);
    }

    public function update($id, $data)
    {
        return $this->testimonialRepo->update($id, $data);
    }
}