<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>QR & Barcode Generator</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        background: '#0a0a0a',
                        foreground: '#fafafa',
                        card: '#141414',
                        border: '#262626',
                        input: '#262626',
                        secondary: '#262626',
                        'secondary-foreground': '#fafafa',
                        muted: '#262626',
                        'muted-foreground': '#a1a1aa',
                        accent: '#22c55e',
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .input-focus:focus {
            outline: none;
            border-color: #22c55e;
            box-shadow: 0 0 0 2px rgba(34, 197, 94, 0.2);
        }

        .btn-primary:hover {
            background-color: #e4e4e7;
        }

        .btn-secondary:hover {
            background-color: #3f3f46;
        }

        .code-display {
            background-image:
                linear-gradient(45deg, #1a1a1a 25%, transparent 25%),
                linear-gradient(-45deg, #1a1a1a 25%, transparent 25%),
                linear-gradient(45deg, transparent 75%, #1a1a1a 75%),
                linear-gradient(-45deg, transparent 75%, #1a1a1a 75%);
            background-size: 20px 20px;
            background-position: 0 0, 0 10px, 10px -10px, -10px 0px;
        }
    </style>
</head>

<body class="bg-background text-foreground min-h-screen">
    <!-- Header -->
    <header class="border-b border-border">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-accent rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-background" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                        </svg>
                    </div>
                    <span class="text-lg font-semibold">CodeGen</span>
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        <!-- Hero Section -->
        <div class="text-center mb-10">
            <span class="inline-block px-3 py-1 text-xs font-medium text-accent bg-accent/10 rounded-full mb-4">
                Free Online Tool
            </span>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-4 text-balance">
                QR Code & Barcode Generator
            </h1>
            <p class="text-muted-foreground max-w-2xl mx-auto text-pretty">
                Generate QR codes and barcodes instantly. Simply enter your URL or text and download your code in
                seconds.
            </p>
        </div>

        <!-- Main Generator Card -->
        <div class="bg-card border border-border rounded-2xl p-6 sm:p-8 mb-8">
            <form id="generatorForm" method="POST" action="{{ route('generate.post') }}">
                @csrf
                <!-- URL/Text Input -->
                <div class="mb-6">
                    <label for="urlInput" class="block text-sm font-medium mb-2">URL or Text</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-muted-foreground" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                            </svg>
                        </div>
                        <input type="text" id="urlInput" name="url" value="{{ old('url') }}"
                            class="w-full bg-input border border-border rounded-xl py-3.5 pl-12 pr-4 text-foreground placeholder-muted-foreground input-focus transition-all"
                            placeholder="https://example.com" required>
                    </div>
                    <p class="mt-2 text-xs text-muted-foreground">
                        Enter any URL, text, or data you want to encode
                    </p>
                    @error('url')
                        <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Generate Button -->
                <button type="submit"
                    class="btn-primary w-full bg-foreground text-background font-medium py-3.5 px-6 rounded-xl transition-all flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    Generate Code
                </button>
            </form>
        </div>

        <!-- Result Section -->
        <div id="resultSection" class="bg-card border border-border rounded-2xl p-6 sm:p-8">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Code Display -->
                <div class="flex-1">
                    <h3 class="text-lg font-semibold mb-4">Generated Code</h3>
                    <div class="code-display bg-secondary rounded-xl p-8 flex items-center justify-center min-h-[280px]">
                        <div id="codePlaceholder" class="text-center text-muted-foreground @if(isset($qr)) hidden @endif">
                            <svg class="w-16 h-16 mx-auto mb-4 opacity-50" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                            </svg>
                            <p>Your code will appear here</p>
                        </div>
                        <div id="qrCodeContainer" class="bg-white p-4 rounded-lg @if(!isset($qr)) hidden @endif">
                            @if(isset($qr))
                                {!! $qr !!}
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="lg:w-72">
                    <h3 class="text-lg font-semibold mb-4">Actions</h3>
                    <div class="space-y-3">
                        <button id="downloadBtn"
                            class="btn-secondary w-full bg-secondary text-secondary-foreground font-medium py-3 px-4 rounded-xl transition-all flex items-center justify-center gap-2 {{ isset($qr) ? '' : 'opacity-50 cursor-not-allowed' }}"
                            {{ isset($qr) ? '' : 'disabled' }}>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Download PNG
                        </button>
                        <button id="copyBtn"
                            class="btn-secondary w-full bg-secondary text-secondary-foreground font-medium py-3 px-4 rounded-xl transition-all flex items-center justify-center gap-2 {{ isset($qr) ? '' : 'opacity-50 cursor-not-allowed' }}"
                            {{ isset($qr) ? '' : 'disabled' }}>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                            Copy to Clipboard
                        </button>
                        <button id="resetBtn"
                            class="w-full text-muted-foreground font-medium py-3 px-4 rounded-xl transition-all flex items-center justify-center gap-2 hover:text-foreground">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Reset
                        </button>
                    </div>

                    <!-- Details Section -->
                    <div id="detailsSection" class="mt-6 pt-6 border-t border-border @if(!isset($qr)) hidden @endif">
                        <h4 class="text-sm font-medium mb-3">Details</h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-muted-foreground">Type</span>
                                <span id="detailType">QR Code</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-muted-foreground">Size</span>
                                <span id="detailSize">300px</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-muted-foreground">Content</span>
                                <span id="detailContent" class="truncate max-w-[120px]" title="{{ old('url') }}">{{ Str::limit(old('url'), 15) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="mt-12 grid sm:grid-cols-3 gap-6">
            <div class="bg-card border border-border rounded-xl p-6">
                <div class="w-10 h-10 bg-accent/10 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <h3 class="font-semibold mb-2">Instant Generation</h3>
                <p class="text-sm text-muted-foreground">Generate codes in milliseconds with our optimized engine.</p>
            </div>
            <div class="bg-card border border-border rounded-xl p-6">
                <div class="w-10 h-10 bg-accent/10 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                    </svg>
                </div>
                <h3 class="font-semibold mb-2">High Quality</h3>
                <p class="text-sm text-muted-foreground">Download in high resolution PNG format for any use case.</p>
            </div>
            <div class="bg-card border border-border rounded-xl p-6">
                <div class="w-10 h-10 bg-accent/10 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <h3 class="font-semibold mb-2">100% Free</h3>
                <p class="text-sm text-muted-foreground">No registration required. Generate unlimited codes for free.
                </p>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="border-t border-border mt-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 text-sm text-muted-foreground">
                <p>Built with Laravel</p>
                <div class="flex items-center gap-4">
                    <a href="#" class="hover:text-foreground transition-colors">Privacy</a>
                    <a href="#" class="hover:text-foreground transition-colors">Terms</a>
                    <a href="#" class="hover:text-foreground transition-colors">Contact</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Reset Button
        document.getElementById('resetBtn').addEventListener('click', function() {
            window.location.href = "{{ route('generate') }}";
        });

        // Download Button
        @if(isset($qr))
        document.getElementById('downloadBtn').addEventListener('click', function() {
            const svg = document.querySelector('#qrCodeContainer svg');
            if (svg) {
                const svgData = new XMLSerializer().serializeToString(svg);
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');
                const img = new Image();

                canvas.width = 300;
                canvas.height = 300;

                img.onload = function() {
                    ctx.fillStyle = 'white';
                    ctx.fillRect(0, 0, canvas.width, canvas.height);
                    ctx.drawImage(img, 0, 0);

                    canvas.toBlob(function(blob) {
                        const url = URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.href = url;
                        a.download = 'qrcode.png';
                        a.click();
                        URL.revokeObjectURL(url);
                    });
                };

                img.src = 'data:image/svg+xml;base64,' + btoa(unescape(encodeURIComponent(svgData)));
            }
        });

        // Copy Button
        document.getElementById('copyBtn').addEventListener('click', async function() {
            const svg = document.querySelector('#qrCodeContainer svg');
            if (svg) {
                const svgData = new XMLSerializer().serializeToString(svg);
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');
                const img = new Image();

                canvas.width = 300;
                canvas.height = 300;

                img.onload = async function() {
                    ctx.fillStyle = 'white';
                    ctx.fillRect(0, 0, canvas.width, canvas.height);
                    ctx.drawImage(img, 0, 0);

                    canvas.toBlob(async function(blob) {
                        try {
                            await navigator.clipboard.write([
                                new ClipboardItem({ 'image/png': blob })
                            ]);
                            alert('QR Code copied to clipboard!');
                        } catch (err) {
                            alert('Failed to copy to clipboard');
                        }
                    });
                };

                img.src = 'data:image/svg+xml;base64,' + btoa(unescape(encodeURIComponent(svgData)));
            }
        });
        @endif
    </script>
</body>

</html>
