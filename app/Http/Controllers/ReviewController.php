<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',

            'rating' => 'required|array',
            'rating.*' => 'required|integer|min:1|max:5',

            'comment' => 'nullable|array',

            'image' => 'nullable|array',
            'image.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'video' => 'nullable|array',
            'video.*' => 'nullable|mimetypes:video/mp4,video/webm,video/ogg|max:20480',
        ]);

        foreach ($request->rating as $productId => $rating) {

            $image = null;
            $video = null;

            if ($request->hasFile("image.$productId")) {
                $image = $request->file("image.$productId")
                    ->store('reviews/images', 'public');
            }

            if ($request->hasFile("video.$productId")) {
                $video = $request->file("video.$productId")
                    ->store('reviews/videos', 'public');
            }

            Review::create([
                'order_id'   => $request->order_id,
                'product_id' => $productId,
                'user_id'    => Auth::id(),
                'rating'     => $rating,
                'comment'    => $request->comment[$productId] ?? null,
                'image'      => $image,
                'video'      => $video,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Ulasan berhasil dikirim.'
        ]);
    }

    public function update(Request $request, Review $review)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'video' => 'nullable|mimes:mp4,mov,avi|max:10240',
        ]);

        $data = [
            'rating' => $request->rating,
            'comment' => $request->comment,
        ];

        if ($request->hasFile('image')) {

            if ($review->image && Storage::disk('public')->exists($review->image)) {
                Storage::disk('public')->delete($review->image);
            }

            $data['image'] = $request->file('image')->store('reviews', 'public');
        }

        if ($request->hasFile('video')) {

            if ($review->video && Storage::disk('public')->exists($review->video)) {
                Storage::disk('public')->delete($review->video);
            }

            $data['video'] = $request->file('video')->store('reviews', 'public');
        }

        $review->update($data);

        return back()->with('success', 'Penilaian berhasil diperbarui.');
    }
}
