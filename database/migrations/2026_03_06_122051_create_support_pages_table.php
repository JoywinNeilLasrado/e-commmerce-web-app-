<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('support_pages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique(); // e.g. 'warranty', 'returns', 'shipping', 'contact'
            $table->string('title');
            $table->text('content');          // Rich text / HTML content
            $table->string('meta_description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Seed default content
        DB::table('support_pages')->insert([
            [
                'slug'             => 'warranty',
                'title'            => 'Warranty Policy',
                'meta_description' => 'Learn about our 12-month warranty coverage for all refurbished phones.',
                'content'          => '<h2>12-Month Warranty</h2><p>All PhoneShop certified refurbished devices come with a comprehensive 12-month warranty from date of purchase.</p><h3>What\'s Covered</h3><ul><li>Hardware defects present at time of purchase</li><li>Battery defects (below 80% health within warranty period)</li><li>Screen issues not caused by physical damage</li><li>Camera, speaker, microphone malfunctions</li><li>Charging port and button failures</li></ul><h3>What\'s Not Covered</h3><ul><li>Physical or accidental damage</li><li>Water or liquid damage</li><li>Damage from unauthorized repairs</li><li>Normal wear and tear</li><li>Lost or stolen devices</li></ul><h3>How to Claim</h3><p>Contact our support team with your order number and description of the issue. We\'ll arrange free pickup and delivery within 7–10 business days.</p>',
                'is_active'        => true,
                'created_at'       => now(),
                'updated_at'       => now(),
            ],
            [
                'slug'             => 'returns',
                'title'            => 'Returns & Refunds',
                'meta_description' => 'Hassle-free 7-day return window on all PhoneShop purchases.',
                'content'          => '<h2>7-Day Return Policy</h2><p>We offer a hassle-free 7-day return window on all purchases from the date of delivery.</p><h3>Eligible for Return</h3><ul><li>Device received in incorrect condition</li><li>Significant defect not disclosed in listing</li><li>Device does not power on or is non-functional</li><li>Missing accessories listed in the product description</li></ul><h3>How to Return</h3><ol><li>Contact support within 7 days of delivery</li><li>Get approval within 24 hours</li><li>Ship device back using our prepaid label</li><li>Receive refund within 3–5 business days after inspection</li></ol><h3>Refund Methods</h3><p>Refunds are processed to the original payment method, via bank transfer, or as store credit.</p>',
                'is_active'        => true,
                'created_at'       => now(),
                'updated_at'       => now(),
            ],
            [
                'slug'             => 'shipping',
                'title'            => 'Shipping Info',
                'meta_description' => 'Fast, tracked delivery across India. Express 1–2 days, Standard 3–5 days.',
                'content'          => '<h2>Delivery Options</h2><p>We partner with India\'s most reliable courier networks for fast, secure delivery.</p><ul><li><strong>Express Delivery:</strong> 1–2 Business Days — ₹99 (Metro cities)</li><li><strong>Standard Delivery:</strong> 3–5 Business Days — ₹49</li><li><strong>Free Shipping:</strong> Orders above ₹15,000 qualify for free standard delivery</li></ul><h3>Order Timeline</h3><ol><li><strong>Day 0:</strong> Order placed and confirmed</li><li><strong>Day 1:</strong> Processing and quality inspection</li><li><strong>Day 1–2:</strong> Dispatched with tracking details sent via email/SMS</li><li><strong>Day 2–5:</strong> Delivered to your doorstep</li></ol><h3>Packaging</h3><p>All devices are packed in anti-static bubble wrap, double-boxed, and sealed with tamper-evident packaging.</p>',
                'is_active'        => true,
                'created_at'       => now(),
                'updated_at'       => now(),
            ],
            [
                'slug'             => 'contact',
                'title'            => 'Contact Us',
                'meta_description' => 'Get in touch with PhoneShop support. We reply within 24 hours.',
                'content'          => '<h2>Get in Touch</h2><p>Our support team is available Monday–Saturday, 10am to 7pm IST. We reply to all queries within 24 hours on business days.</p><ul><li><strong>Email:</strong> support@phoneshop.in</li><li><strong>Phone:</strong> +91 98765 43210</li><li><strong>Address:</strong> PhoneShop HQ, 4th Floor, Tech Park, Whitefield, Bangalore – 560066</li></ul>',
                'is_active'        => true,
                'created_at'       => now(),
                'updated_at'       => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('support_pages');
    }
};
