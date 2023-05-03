<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Services\GameExport\GameExportContext;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response as ResponseFacade;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): view
    {
        return view('games.index', [
            'games' => Game::with('user')->latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $request->user()->games()->create($validated);

        return redirect(route('games.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Game $game)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Game $game)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Game $game)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game): RedirectResponse
    {
        $this->authorize('delete', $game);

        $game->delete();

        return redirect(route('games.index'));
    }

    public function export(string $type): Response
    {
        $games = Game::all();
        $context = new GameExportContext();

        $concreteStrategyClassname = $context->loadStrategyByName($type);

        if ($concreteStrategyClassname === null) {
            throw new NotFoundHttpException(sprintf('The format %s is unknown.', $type));
        }

        $strategy = new $concreteStrategyClassname;
        $context->setStrategy($strategy);

        // Headers could be encapsulated in strategies.
        $headers = [
            'Content-Type' => 'text/'.$type,
            'Content-Disposition' => 'attachment; filename="games.'.$type.'"',
        ];

        // Return CSV file for download
        return ResponseFacade::make($context->execute($games), 200, $headers);
    }
}
