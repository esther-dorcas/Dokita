{{-- ══════════ FOOTER ══════════ --}}
<footer class="bg-slate-950 text-slate-300 w-full border-t border-slate-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid gap-12 lg:grid-cols-4">
            <div>
                <span class="inline-flex items-center justify-center border-2 border-white/30 px-3 py-1.5 rounded-lg">
                    <span class="text-white font-black text-lg">Dokita</span>
                </span>
                <p class="mt-4 text-sm leading-7 text-slate-400">Plateforme e-santé pour la prise de rendez-vous, la géolocalisation d'hôpitaux et les rappels automatiques au Bénin.</p>
                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="#" class="rounded-lg border border-white/10 px-4 py-2 text-sm font-semibold text-white hover:bg-white/10 transition">Support</a>
                    <a href="{{ route('faq') }}" class="rounded-lg border border-white/10 px-4 py-2 text-sm font-semibold text-white hover:bg-white/10 transition">FAQ</a>
                </div>
            </div>
            <div>
                <h3 class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500 mb-5">Navigation</h3>
                <ul class="space-y-3 text-sm">
                    <li><a href="{{ route('home') }}#hospitaux"   class="hover:text-white transition font-semibold">Hôpitaux</a></li>
                    <li><a href="{{ route('professional') }}"    class="hover:text-white transition font-semibold">Médecins</a></li>
                    <li><a href="{{ route('home') }}#temoignages" class="hover:text-white transition font-semibold">Témoignages</a></li>
                    <li><a href="{{ route('faq') }}"              class="hover:text-white transition font-semibold">FAQ</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500 mb-5">Contact</h3>
                <p class="text-sm text-slate-400">support@dokita.bj</p>
                <p class="mt-3 text-sm text-slate-400">+229 45 92 63 13</p>
                <p class="mt-3 text-xs text-slate-500">Lun–Dim 00:00–00:00</p>
            </div>
            <div>
                <h3 class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500 mb-5">Réseaux</h3>
                <div class="flex flex-wrap gap-3 text-white">
                    <a href="https://facebook.com/dokita" target="_blank" rel="noopener noreferrer" class="rounded-lg border border-white/10 p-2.5 text-sm font-semibold hover:bg-[#1877F2] hover:border-[#1877F2] transition group" aria-label="Facebook">
                        <svg class="w-5 h-5 text-slate-300 group-hover:text-white transition" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"/></svg>
                    </a>
                    <a href="https://twitter.com/dokita_bj" target="_blank" rel="noopener noreferrer" class="rounded-lg border border-white/10 p-2.5 text-sm font-semibold hover:bg-black hover:border-black transition group" aria-label="Twitter X">
                        <svg class="w-5 h-5 text-slate-300 group-hover:text-white transition" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>
                    <a href="https://instagram.com/dokita_bj" target="_blank" rel="noopener noreferrer" class="rounded-lg border border-white/10 p-2.5 text-sm font-semibold hover:bg-gradient-to-tr hover:from-yellow-400 hover:via-pink-500 hover:to-purple-500 transition group" aria-label="Instagram">
                        <svg class="w-5 h-5 text-slate-300 group-hover:text-white transition" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd"/></svg>
                    </a>
                </div>
                <div class="mt-6 rounded-2xl border border-white/10 bg-white/5 p-5">
                    <p class="text-xs uppercase tracking-widest text-slate-500 font-bold">Sécurité</p>
                    <p class="mt-2 text-sm text-slate-400 leading-relaxed">Vos informations sont protégées et utilisées uniquement pour la gestion des rendez-vous.</p>
                </div>
            </div>
        </div>
        <div class="mt-12 border-t border-slate-800 pt-8 text-xs text-slate-600 text-center">© {{ date('Y') }} Dokita. Tous droits réservés.</div>
    </div>
</footer>
