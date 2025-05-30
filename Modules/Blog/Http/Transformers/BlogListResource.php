<?php

namespace Modules\Blog\Http\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->getAttribute('name'),
            'slug' => $this->getAttribute('slug'),
            'date' => \Carbon\Carbon::parse($this->getAttribute('date'))->format('d F, Y'),
            'category' => [
                'slug' => $this->category->slug,
                'name' => $this->category->name

            ],
            'description' => $this->getAttribute('description'),
//            'image'=>$this->image()
            'images' => [
                'https://themesflat.co/html/proty/images/blog/blog-grid-1.jpg',
                'https://themesflat.co/html/proty/images/blog/blog-grid-2.jpg',
                'https://themesflat.co/html/proty/images/blog/blog-grid-3.jpg',
                'https://themesflat.co/html/proty/images/blog/blog-grid-4.jpg',
            ],
                'author' => 'Kathryn Murphy',
                'content' => [
                    "The housing sector has long been a focal point for investors seeking stability and growth. Understanding the dynamics of housing stocks and effectively trading within this sector can lead to substantial gains.",
                    "Understanding Housing Stocks: Housing stocks encompass companies involved in various aspects of the real estate industry, including homebuilders, developers, and related service providers. Factors influencing these stocks range from interest rates and economic indicators to trends in homeownership rates.",
                    "Pay close attention to economic indicators such as employment rates, GDP growth, and consumer confidence. A strong economy often correlates with increased demand for housing, benefiting related stocks.",
                    "Identify Emerging Trends: Stay informed about emerging trends in the housing market, such as the demand for sustainable homes, technological advancements, and demographic shifts. Companies aligning with these trends may present attractive investment opportunities.",
                    "Take a long-term investment approach if you believe in the stability and growth potential of the housing sector. Look for companies with solid fundamentals and a track record of success. For short-term traders, capitalize on market fluctuations driven by economic reports, interest rate changes, or industry-specific news. Keep a close eye on earnings reports and government housing data releases."
                ]


        ];
    }
}
