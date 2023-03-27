import './bootstrap';

let SelectedYear = '12';

changeOption();
document.getElementById("selectYear").addEventListener("change", (e) => {
    SelectedYear = e.target.value;
    changeOption();
});

function changeOption() {
    if (SelectedYear === '1') {
        document.getElementById("filierSelect").innerHTML = `
    <option value="all_a1" >La Somme De Toutes Les Filière 1A</option>
    <option value="GC_GE_TS">Gestion des Entreprises</option>
    <option value="DIA_ID_TS">Infrastructure Digitale</option>
    <option value="AG_IF_TS">Technicien Spécialisé en Production Graphique</option>
    <option value="AG_INFO_TS">Infographie</option>
    <option value="GC_AA_T">Assistant Administratif</option>

    `;
    } else if (SelectedYear === '2') {
        document.getElementById("filierSelect").innerHTML = `
        <option value="all_a2" >La Somme De Toutes Les Filière 2A</option>

            <option value="AG_IF_TS">
             Technicien Spécialisé en Production Graphique

            </option>

            <option value="AG_INFO_TS">
             Infographie
            </option>

            
            <option value="AGC_COMPT_BP">
                Comptabilité
            </option>
            <option value="AGC_TSGE_TS_RCDS">
                (CDS)Technicien Spécialisé en Gestion des Entreprises

            </option>
            <option value="GC_GEOCF_TS">
                Gestion des Entreprises option Comptabilité et Finance

            </option>
            <option value="DIA_DEVOWFS_TS">
                Développement Digital option Web Full Stack

            </option>
            <option value="DIA_IDOSR_TS">
                Infrastructure Digitale option Systèmes et Réseaux

            </option>
            <option value="BP_TCPS_BP">
                Tronc commun professionnel service

            </option>
            <option value="AGC_C_BP">
                Commerce
            </option>
            <option value="NTIC_TDI_TS_RCDS">
                (CDS)Techniques de Développement Informatique

            </option>
            <option value="DIA_DEVOAM_TS">
                Développement Digital option Applications Mobiles

            </option>
            <option value="GC_GEOCM_TS">
                Gestion des Entreprises option Commerce et Marketing

            </option>
            <option value="GC_GEORH_TS">
                Gestion des Entreprises option Ressources Humaines

            </option>
            <option value="GC_AAOG_T">
                Assistant Administratif option Gestion

            </option>
            <option value="GC_GEOOM_TS">
                Gestion des Entreprises option Office Manager

            </option>
            <option value="GC_AAOCP_T">
                Assistant Administratif option Comptabilité

            </option>
            <option value="GC_AAOC_T">
                Assistant Administratif option Commerce
            </option>
            <option value="DIA_IDOCC_TS">
                Infrastructure Digitale option Cloud Computing
            </option>
            
    `;
    }else {
        document.getElementById("filierSelect").innerHTML =`
        <option value="all">La Somme De Toutes Les Filière 1A & 2A</option>
        `
    }
}
