<?php

class Profil{
    //ATTRIBUTS
    private string $firstname = "";
    private string $lastname = "";
    private string $email = "";
    private string $role = "";
    private string $createdAt = "";

    //GETTERS SETTERS
    public function getFirstname(): string {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self {
        $this->firstname = $firstname;
        return $this;
    }

    public function getLastname(): string {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self {
        $this->lastname = $lastname;
        return $this;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function setEmail(string $email): self {
        $this->email = $email;
        return $this;
    }

    public function getRole(): string {
        return $this->role;
    }

    public function setRole(string $role): self {
        $this->role = $role;
        return $this;
    }

    public function getCreatedAt(): string {
        return $this->createdAt;
    }

    public function setCreatedAt(string $createdAt): self {
        $this->createdAt = $createdAt;
        return $this;
    }

    //AFFICHAGE
    public function display(): void {
?>
        <main>
            <h2>Mon Compte</h2>
            <p><?php echo(htmlspecialchars($this->firstname)." ".htmlspecialchars($this->lastname)) ?></p>
            <p>Email : <?php echo(htmlspecialchars($this->email)) ?></p>
            <p>Role : <?php echo(htmlspecialchars($this->role)) ?></p>
            <p>Date d'enregistrement : <?php echo(htmlspecialchars($this->createdAt)) ?></p>
        </main>
    </body>
    </html>
<?php
    }
}
