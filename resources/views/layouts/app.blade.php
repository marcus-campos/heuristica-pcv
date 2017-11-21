<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Heuristica') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style type="text/css" media="screen">
        #graphDiv {
            background-color: black;
            top: 0;
            left:0;
            height: 450px;
            width: 100%;
            position: relative;
            margin:0;
            overflow: hidden;
        }
        .node-label {
            position: absolute;
            pointer-events: none;
            color: white;
            z-index: 10;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Heuristica') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                            <li><a href="{{ route('aresta.index') }}">Incluir aresta</a></li>
                            <li><a href="{{ route('aresta.remover.index') }}">Remover aresta</a></li>
                            <li><a href="{{ route('aresta.alterar.index') }}">Alterar peso de aresta</a></li>
                            <li><a href="{{ route('aresta.exibir') }}">Exibir grafo</a></li>
                            <li><a href="{{ route('aresta.pcv') }}">Menor caminho</a></li>
                            <li><a href="{{ route('aresta.reiniciar') }}">Reiniciar grafo</a></li>
                            <li><a href="{{ route('sair') }}">Sair</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/vivagraph.min.js') }}"></script>
    <script>
        var graph = Viva.Graph.graph();
        @if(count(\session('grafo')) > 0)
            @foreach(\session('grafo') as $aresta)
                graph.addLink({{ $aresta['i'] }}, {{ $aresta['j'] }});
            @endforeach
        @endif
        var container = document.getElementById('graphDiv');
        var domLabels = generateDOMLabels(graph);
        var layout = Viva.Graph.Layout.forceDirected(graph, {
            gravity : -0.1
        });
        var graphics = Viva.Graph.View.webglGraphics();
        graphics.placeNode(function(ui, pos) {
            // This callback is called by the renderer before it updates
            // node coordinate. We can use it to update corresponding DOM
            // label position;
            // we create a copy of layout position
            var domPos = {
                x: pos.x,
                y: pos.y
            };
            // And ask graphics to transform it to DOM coordinates:
            graphics.transformGraphToClientCoordinates(domPos);
            // then move corresponding dom label to its own position:
            var nodeId = ui.node.id;
            var labelStyle = domLabels[nodeId].style;
            labelStyle.left = domPos.x + 'px';
            labelStyle.top = domPos.y + 'px';
        });

        // specify where it should be rendered:
        var renderer = Viva.Graph.View.renderer(graph, {
            container: document.getElementById('graphDiv'),
            graphics: graphics,
            layout: layout
        });
        renderer.run();
        function generateDOMLabels(graph) {
            // this will map node id into DOM element
            var labels = Object.create(null);
            graph.forEachNode(function(node) {
                var label = document.createElement('span');
                label.classList.add('node-label');
                label.innerText = node.id;
                labels[node.id] = label;
                container.appendChild(label);
            });
            // NOTE: If your graph changes over time you will need to
            // monitor graph changes and update DOM elements accordingly
            return labels;
        }
    </script>
</body>
</html>
