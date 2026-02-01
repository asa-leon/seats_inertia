<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use App\Models\Seat;

class SeatController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		// Index.vueを返すルーティイング（web.phpにて、'/'へアクセスするとこのコントローラーを参照する様に設定済み。
		return Inertia::render('Index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function show(Request $request)
	{
		// 'Confirm'で修正をタップされた場合に、データを'Index'に返す
		$request->validateWithBag(
			'show',
			[
				'guestsCountInput' => 'required',
				'selectedSeatTypes' => 'required'
			]
		);

		return Inertia::render('Index', [
			'request' => $request
		]);
	}

	/**
	 * Confirmation of input and seleted seats are available or not.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function confirm(Request $request, Seat $seat)
	{
		$request->validateWithBag(
			'confirm',
			[
				'guestsCountInput' => 'required',
				'selectedSeatTypes' => 'required'
			]
		);

		$guestsCount = $request->guestsCountInput;
		$selectedSeats = $request->selectedSeatTypes;

		// array([ 選択された席種 => 席種の最大定員の余り ]) : 余りの少ない順
		$prioritizedOrderForGuidance = [];

		foreach ($selectedSeats as $selectedSeat) {

			// DBの席種の最大定員を取得
			$maxGuests = $seat::select('maxGuestsPerSeat')->where('seatType', $selectedSeat['id'])->first();

			// DBの席種の空席数を取得
			$remaining = $seat::select('remainingSeats')->where('seatType', $selectedSeat['id'])->first();

			// 上述の2つの値を掛けた数を以下の変数に代入して定義
			$maxPeopleByRemainingSeat = $maxGuests->maxGuestsPerSeat * $remaining->remainingSeats;

			// 入力された人数に対して、席種の最大定員と席種の残数を掛けた数を比較し、
			// 前者が後者以下であれば空席があるとして、Confirmに渡す情報を作成していく。
			if ($guestsCount <= $maxPeopleByRemainingSeat) {

				// なるべく一つの席種の最大定員を埋める様に案内する為、
				//入力された人数を席種の最大定員で割って残る席が少ない順に並べる。
				if ($guestsCount % $maxGuests->maxGuestsPerSeat == 0) {

					$remainOfOneSeatType = 0;
					$selectedSeat['priorityFromZero'] = $remainOfOneSeatType;
				} else {

					$remainOfOneSeatType = $maxGuests->maxGuestsPerSeat - ($guestsCount % $maxGuests->maxGuestsPerSeat);
					$selectedSeat['priorityFromZero'] = $remainOfOneSeatType;
				}

				array_push($prioritizedOrderForGuidance, $selectedSeat);
			}
		}

		// 一つの席で余る数の少ない順に並び替える
		usort($prioritizedOrderForGuidance, function ($v1, $v2) {
			return $v1['priorityFromZero'] > $v2['priorityFromZero'];
		});

		return Inertia::render('Confirm', [
			'request' => $request,
			'prioritizedOrderForGuidance' => $prioritizedOrderForGuidance
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function confirmed(Request $request, Seat $seat)
	{
		// 確定ボタンが押された後、客数と席種に応じてDBの残席数を書き換える
		$request->validateWithBag(
			'confirmed',
			[
				'guestsCountInput' => 'required',
				'prioritizedOrderForGuidance' => 'required'
			]
		);

		$guestsCount = $request->guestsCountInput;
		$prioritySeatType = $request->prioritizedOrderForGuidance;

		// DBの席種の空席数を取得
		$remaining = $seat::select('remainingSeats')->where('seatType', $prioritySeatType[0]['id'])->first();

		// DBの席種の最大定員を取得
		$maxGuests = $seat::select('maxGuestsPerSeat')->where('seatType', $prioritySeatType[0]['id'])->first();

		// 上述の2つの値を掛けた数を以下の変数に代入して定義
		$maxPeopleByRemainingSeat = $maxGuests->maxGuestsPerSeat * $remaining->remainingSeats;

		$seatsCountToSubtract = ceil($guestsCount / $maxGuests->maxGuestsPerSeat);

		$updatingData = $remaining->remainingSeats - $seatsCountToSubtract;

		$seat::select('remainingSeats')
			->where('seatType', $prioritySeatType[0]['id'])
			->update(['remainingSeats' => $updatingData]);

		//dd($remaining);

		return Inertia::render('Confirmed', [
			'request' => $request
		]);
	}



	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		//
	}
}
