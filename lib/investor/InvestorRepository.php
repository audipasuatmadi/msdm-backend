<?php

namespace lib\investor;

use interfaces\IDatabase;
use lib\investor\interfaces\IInvestorRepository;

class InvestorRepository implements IInvestorRepository
{
    private IDatabase $database;

    public function __construct(IDatabase $database)
    {
        $this->database = $database;
    }

    public function store($name, $stocks)
    {
        $conn = $this->database->connect();
        $stmt = $conn->prepare(
            "INSERT INTO investor (nama, jml_saham)
            VALUES (?, ?)"
        );
        $stmt->prepare("si", $name, $stocks);
        $execResult = $stmt->execute();
        if ($execResult == 1) {
            $conn->close();
            return ["status" => 201];
        }
        $conn->close();
        return ["status" => 500];
    }

    public function getAll()
    {
        $conn = $this->database->connect();
        $stmt = $conn->prepare(
            "SELECT * FROM investor"
        );
        $execResult = $stmt->execute();
        if ($execResult == 1) {
            $results = $stmt->get_result();
            if ($results->num_rows > 0) {
                $allInvestor = $results->fetch_all(MYSQLI_ASSOC);
                $conn->close();
                return ["status" => 200, "payload" => $allInvestor];
            }
            $conn->close();
            return ["status" => 404];
        }
        $conn->close();
        return ["status" => 500];
    }

    public function update($id, $name, $stocks)
    {
        $conn = $this->database->connect();

        $stmt = $conn->prepare(
            "UPDATE investor
            SET nama=?,
            jml_saham=?
            WHERE id=?"
        );
        $stmt->bind_param("sii", $name, $stocks, $id);

        $execResult = $stmt->execute();
        if ($execResult == 1) {
            $conn->close();
            return ["status" => 200];
        }
        $conn->close();
        return ["status" => 500];
    }

    public function delete($id)
    {
        $conn = $this->database->connect();

        $stmt = $conn->prepare(
            "DELETE FROM investor WHERE id=?"
        );
        $stmt->prepare("i", $id);

        $execResult = $stmt->execute();
        if ($execResult == 1) {
            $conn->close();
            return ["status" => 200];
        }
        $conn->close();
        return ["status" => 500];
    }
}